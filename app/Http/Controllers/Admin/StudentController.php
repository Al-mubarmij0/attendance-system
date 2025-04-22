<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student; // Or your student model
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Display the list of students
    public function index()
    {
        $students = Student::all(); // Or paginate if you have a lot of students
        return view('admin.students.index', compact('students'));
    }

    // Show form to create a new student
    public function create()
    {
        return view('admin.students.create');
    }

    // Store the new student
    public function store(Request $request)
    {
        // Validation and storing logic here
    }

    // Show form to edit an existing student
    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    // Update an existing student
    public function update(Request $request, Student $student)
    {
        // Validation and updating logic here
    }

    // Delete a student
    public function destroy(Student $student)
    {
        // Deleting logic here
    }
}
