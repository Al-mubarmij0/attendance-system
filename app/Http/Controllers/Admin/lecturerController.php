<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\User;
use App\Models\Course; // Import the Course model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Import the Rule class
use Illuminate\Support\Facades\DB; // Import DB facade for transactions
use Illuminate\Validation\ValidationException; // Import ValidationException for specific catch

class LecturerController extends Controller
{
    /**
     * Display a listing of the lecturers.
     */
    public function index()
    {
        $lecturers = Lecturer::with('user')->orderBy('created_at', 'desc')->paginate(10);
        // Fetch all courses to pass to the add lecturer modal
        $allCourses = Course::with('lecturer.user')->orderBy('name')->get(); // Eager load current lecturer for display
        return view('admin.lecturers.index', compact('lecturers', 'allCourses'));
    }

    /**
     * Store a newly created lecturer in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|confirmed|min:8',
            'staff_id'       => 'required|string|unique:lecturers,staff_id',
            'specialization' => 'required|string|max:255',
            'bio'            => 'nullable|string',
            // Add validation for assigned_courses
            'assigned_courses' => 'nullable|array', // Expects an array of course IDs
            'assigned_courses.*' => 'exists:courses,id', // Ensures each course ID actually exists
        ]);

        DB::beginTransaction(); // Start a database transaction

        try {
            // Create User
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['email'],
                'role'     => 'lecturer',
                'password' => Hash::make($validatedData['password']),
            ]);

            // Create Lecturer Profile linked to the User
            $lecturer = $user->lecturer()->create([
                'staff_id'       => $validatedData['staff_id'],
                'specialization' => $validatedData['specialization'],
                'bio'            => $validatedData['bio'] ?? null,
            ]);

            // Assign selected courses to this new lecturer
            if (!empty($validatedData['assigned_courses'])) {
                // Update the lecturer_id for these courses to the new lecturer's ID
                // Only update courses that are currently unassigned (lecturer_id is null)
                // or previously assigned to this lecturer (to prevent overwriting other lecturers' assignments)
                Course::whereIn('id', $validatedData['assigned_courses'])
                      ->where(function ($query) use ($lecturer) {
                          $query->whereNull('lecturer_id')
                                ->orWhere('lecturer_id', $lecturer->id);
                      })
                      ->update(['lecturer_id' => $lecturer->id]);
            }

            DB::commit(); // Commit the transaction if everything is successful

            return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer added successfully and courses assigned.');

        } catch (ValidationException $e) {
            DB::rollBack(); // Rollback on validation error
            return redirect()->back()
                             ->withInput()
                             ->withErrors($e->errors())
                             ->with('open_add_lecturer_modal', true);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on any other general error
            \Log::error("Lecturer Store Error (with Course Assignment): " . $e->getMessage() . " - " . $e->getFile() . " on line " . $e->getLine());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Error adding lecturer and assigning courses: ' . $e->getMessage())
                             ->with('open_add_lecturer_modal', true);
        }
    }

    /**
     * Show the form for editing the specified lecturer.
     */
    public function edit(Lecturer $lecturer)
    {
        // Eager load the user relationship AND the courses assigned to this lecturer
        $lecturer->load('user', 'courses');
        // Fetch all courses for the dropdown, eager loading their current lecturer (if any)
        $allCourses = Course::with('lecturer.user')->orderBy('name')->get();
        return view('admin.lecturers.edit', compact('lecturer', 'allCourses'));
    }

    /**
     * Update the specified lecturer in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => [
                'required',
                'email',
                Rule::unique('users')->ignore($lecturer->user_id),
            ],
            'password'       => 'nullable|confirmed|min:8',
            'staff_id'       => [
                'required',
                'string',
                Rule::unique('lecturers')->ignore($lecturer->id),
            ],
            'specialization' => 'required|string|max:255',
            'bio'            => 'nullable|string',
            // Add validation for assigned_courses
            'assigned_courses' => 'nullable|array',
            'assigned_courses.*' => 'exists:courses,id',
        ]);

        DB::beginTransaction(); // Start a database transaction

        try {
            // Update User
            $user = $lecturer->user;
            $user->name  = $validatedData['name'];
            $user->email = $validatedData['email'];

            if ($request->filled('password')) {
                $user->password = Hash::make($validatedData['password']);
            }
            $user->save();

            // Update Lecturer profile
            $lecturer->update([
                'staff_id'       => $validatedData['staff_id'],
                'specialization' => $validatedData['specialization'],
                'bio'            => $validatedData['bio'],
            ]);

            // --- Logic for updating course assignments ---
            $currentlyAssignedCourseIds = $lecturer->courses->pluck('id')->toArray();
            $selectedCourseIds = $validatedData['assigned_courses'] ?? [];

            // 1. Detach courses no longer selected from *this* lecturer
            // Set lecturer_id to null for courses that were previously assigned to this lecturer
            // but are no longer in the selected list.
            $coursesToDetach = array_diff($currentlyAssignedCourseIds, $selectedCourseIds);
            if (!empty($coursesToDetach)) {
                Course::whereIn('id', $coursesToDetach)
                      ->where('lecturer_id', $lecturer->id) // Crucially only affect courses assigned to this lecturer
                      ->update(['lecturer_id' => null]);
            }

            // 2. Attach newly selected courses to this lecturer
            // Only assign if they are not already assigned to THIS lecturer AND are currently unassigned.
            // If you want to allow overwriting an assignment from another lecturer, remove `whereNull('lecturer_id')`
            // but be aware of the implications (silent re-assignment).
            $coursesToAttach = array_diff($selectedCourseIds, $currentlyAssignedCourseIds);
            if (!empty($coursesToAttach)) {
                 Course::whereIn('id', $coursesToAttach)
                       ->whereNull('lecturer_id') // Only assign if currently unassigned
                       ->update(['lecturer_id' => $lecturer->id]);
            }

            DB::commit(); // Commit the transaction

            return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer updated successfully and courses reassigned.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            \Log::error("Lecturer Update Error (with Course Assignment): " . $e->getMessage() . " - " . $e->getFile() . " on line " . $e->getLine());
            return redirect()->back()->withInput()->with('error', 'Error updating lecturer: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified lecturer from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        DB::beginTransaction(); // Start transaction for deletion

        try {
            // Courses assigned to this lecturer will have their lecturer_id set to null
            // if onDelete('set null') is used in the migration.
            // No explicit Course update needed here, as the database handles it.

            // Delete the associated User (which should cascade delete the Lecturer profile if foreign key is set up)
            if ($lecturer->user) {
                $lecturer->user->delete();
            } else {
                // Fallback: If user is missing, delete lecturer directly
                $lecturer->delete();
            }

            DB::commit(); // Commit the transaction

            // Return JSON response for AJAX
            return response()->json(['success' => true, 'message' => 'Lecturer and associated courses unassigned, lecturer deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            // Return JSON error response for AJAX
            \Log::error("Lecturer Destroy Error: " . $e->getMessage() . " - " . $e->getFile() . " on line " . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Error deleting lecturer: ' . $e->getMessage()], 500);
        }
    }
}