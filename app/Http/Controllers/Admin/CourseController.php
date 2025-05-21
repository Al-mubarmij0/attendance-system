<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('students')
            ->with('lecturer')
            ->orderBy('code')
            ->get();
            
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:courses|max:10',
            'name' => 'required|max:100',
            'department' => 'required',
            'credits' => 'required|integer|between:1,6',
            'description' => 'nullable|string',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => 'required|max:10|unique:courses,code,'.$course->id,
            'name' => 'required|max:100',
            'department' => 'required',
            'credits' => 'required|integer|between:1,6',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json(['success' => 'Course deleted successfully']);
    }

    public function manage(Course $course)
    {
        $lecturers = \App\Models\Lecturer::all();
        $students = \App\Models\Student::whereDoesntHave('courses', function($query) use ($course) {
            $query->where('course_id', $course->id);
        })->get();

        return view('admin.courses.manage', compact('course', 'lecturers', 'students'));
    }

    public function assignLecturer(Request $request, Course $course)
    {
        $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id'
        ]);

        $course->lecturer_id = $request->lecturer_id;
        $course->save();

        return back()->with('success', 'Lecturer assigned successfully');
    }

    public function enrollStudents(Request $request, Course $course)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id'
        ]);

        $course->students()->attach($request->student_ids);

        return back()->with('success', 'Students enrolled successfully');
    }

    public function removeStudent(Course $course, $studentId)
    {
        $course->students()->detach($studentId);

        return back()->with('success', 'Student removed from course');
    }
}