<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course; // Make sure to import the Course model

class LecturerController extends Controller
{
    /**
     * Display the lecturer dashboard.
     */
    public function index()
    {
        // Get the authenticated user and eager-load their lecturer profile
        // This is crucial to access lecturer-specific data and relationships like 'courses'
        $user = Auth::user()->load('lecturer');

        // Access the lecturer profile through the user relationship
        $lecturer = $user->lecturer;

        // Initialize assignedCourses as an empty collection
        $assignedCourses = collect();

        // If a lecturer profile exists, load their courses
        if ($lecturer) {
            $assignedCourses = $lecturer->courses; // Assuming Lecturer model has a hasMany('Course') relationship
        }

        // Pass both user and lecturer (and assignedCourses if needed for dashboard display)
        return view('lecturer.dashboard', compact('user', 'lecturer', 'assignedCourses'));
    }

    /**
     * Display courses assigned to the lecturer.
     */
    public function courses()
    {
        // Get the authenticated user and eager-load their lecturer profile
        $user = Auth::user()->load('lecturer');

        $lecturer = $user->lecturer;
        $courses = collect(); // Initialize as empty collection

        if ($lecturer) {
            // Fetch courses specifically assigned to this lecturer, ordered by name
            $courses = $lecturer->courses()->orderBy('name')->get();
        }

        // The view name 'lecturer.courses' implies `resources/views/lecturer/courses.blade.php`
        // If it's `resources/views/lecturer/courses/index.blade.php`, adjust the view name here.
        return view('lecturer.courses.index', compact('courses'));
    }

    /**
     * Display the lecturer's schedule.
     */
    public function schedule()
    {
        // Ensure the user's lecturer relationship is loaded
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;
        $schedules = collect(); // Initialize as empty collection

        if ($lecturer) {
            // Assuming Lecturer model has a hasMany('ClassSchedule') relationship
            $schedules = $lecturer->classSchedules()->orderBy('class_date')->orderBy('start_time')->get();
        }

        return view('lecturer.schedule.index', compact('schedules'));
    }

    /**
     * Show form to create a new class schedule.
     */
    public function createSchedule()
    {
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;
        $courses = collect(); // Initialize as empty collection

        if ($lecturer) {
            $courses = $lecturer->courses()->orderBy('name')->get();
        }

        return view('lecturer.schedule.create', compact('courses'));
    }

    /**
     * Store the newly created class schedule.
     */
    public function storeSchedule(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'class_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;

        if (!$lecturer) {
            return redirect()->back()->with('error', 'Lecturer profile not found.');
        }

        // Use the lecturer's specific relationship to create the schedule
        $lecturer->classSchedules()->create([ // Assuming classSchedules() is the correct relationship name
            'course_id' => $request->course_id,
            'class_date' => $request->class_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        return redirect()->route('lecturer.schedule')->with('success', 'Class scheduled successfully.');
    }

    /**
     * Edit schedule form.
     */
    public function editSchedule($id)
    {
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;

        if (!$lecturer) {
            abort(404, 'Lecturer profile not found.');
        }

        $schedule = $lecturer->classSchedules()->findOrFail($id); // Use the relationship to ensure ownership
        $courses = $lecturer->courses()->orderBy('name')->get();

        return view('lecturer.schedule.edit', compact('schedule', 'courses'));
    }

    /**
     * Update an existing schedule.
     */
    public function updateSchedule(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'class_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;

        if (!$lecturer) {
            return redirect()->back()->with('error', 'Lecturer profile not found.');
        }

        $schedule = $lecturer->classSchedules()->findOrFail($id); // Ensure ownership

        $schedule->update($request->only([
            'course_id', 'class_date', 'start_time', 'end_time', 'location', 'notes'
        ]));

        return redirect()->route('lecturer.schedule')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Delete a schedule.
     */
    public function destroySchedule($id)
    {
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;

        if (!$lecturer) {
            return redirect()->back()->with('error', 'Lecturer profile not found.');
        }

        $schedule = $lecturer->classSchedules()->findOrFail($id); // Ensure ownership
        $schedule->delete();

        return redirect()->route('lecturer.schedule')->with('success', 'Schedule deleted successfully.');
    }

    /**
     * Show the QR code scanner for attendance marking.
     */
    public function scanAttendance()
    {
        return view('lecturer.attendance.scan');
    }

    /**
     * Display attendance reports for the lecturer's courses.
     */
    public function attendanceReports()
    {
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;
        $attendanceReports = collect(); // Initialize as empty collection

        if ($lecturer) {
            // You'll need to define how attendance reports are related.
            // This might involve fetching attendances through courses.
            // For example:
            // $attendanceReports = Attendance::whereIn('course_id', $lecturer->courses->pluck('id'))->get();
            // For now, I'm keeping your original placeholder, but be aware it might need more logic.
            // Assuming a relationship like $lecturer->attendanceReports exists if it's a direct relation.
            // If attendance is tied to courses, you'd fetch it via courses.
            // Example: $attendanceReports = $lecturer->courses->flatMap(fn($course) => $course->attendances);
        }

        return view('lecturer.attendance.reports', compact('attendanceReports'));
    }

    /**
     * Display the lecturer's profile information.
     */
    public function profile()
    {
        // No need to load lecturer here, as it's typically loaded by Auth::user() by default
        // if your User model has a lecturer() relationship defined and eager loaded globally
        // or if you access it directly like Auth::user()->lecturer
        $user = Auth::user()->load('lecturer'); // Ensure lecturer profile is loaded
        $lecturer = $user->lecturer; // Access the lecturer profile

        return view('lecturer.profile', compact('user', 'lecturer')); // Pass user and lecturer
    }
}