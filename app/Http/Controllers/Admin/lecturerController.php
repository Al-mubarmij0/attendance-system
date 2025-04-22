<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('admin.lecturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|confirmed|min:6',
            'staff_id'       => 'required|unique:lecturers,staff_id',
            'specialization' => 'required|string|max:255',
            'bio'            => 'nullable|string',
        ]);

        // Create User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'lecturer',
            'password' => Hash::make($request->password),
        ]);

        // Create Lecturer Profile
        $user->lecturer()->create([
            'staff_id'       => $request->staff_id,
            'specialization' => $request->specialization,
            'bio'            => $request->bio,
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer added successfully.');
    }

    public function edit(Lecturer $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $lecturer->user_id,
            'password'       => 'nullable|confirmed|min:6',
            'staff_id'       => 'required|unique:lecturers,staff_id,' . $lecturer->id,
            'specialization' => 'required|string|max:255',
            'bio'            => 'nullable|string',
        ]);

        // Update User
        $user = $lecturer->user;
        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update Lecturer
        $lecturer->update([
            'staff_id'       => $request->staff_id,
            'specialization' => $request->specialization,
            'bio'            => $request->bio,
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer deleted successfully.');
    }
}
