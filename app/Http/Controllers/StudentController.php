<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\ClassSchedule;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->isStudent() || !$user->student) {
            return view('student.dashboard', [
                'user' => $user,
                'studentProfile' => null,
                'enrolledCourses' => collect(),
                'upcomingSchedules' => collect(),
            ]);
        }

        $studentProfile = $user->student;
        $enrolledCourses = $studentProfile->enrolledCourses;
        $upcomingSchedules = collect();

        if ($enrolledCourses->isNotEmpty()) {
            $offeredCourseIds = $enrolledCourses->pluck('id');

            $upcomingSchedules = ClassSchedule::whereIn('course_id', $offeredCourseIds)
                ->where('day', '>=', now()->toDateString())
                ->orderBy('day')
                ->orderBy('start_time')
                ->with('course', 'lecturer')
                ->get();
        }

        return view('student.dashboard', compact('user', 'studentProfile', 'enrolledCourses', 'upcomingSchedules'));
    }

    // ✅ Show enrollment form
    public function showEnrollmentForm()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            abort(403, 'Access denied.');
        }

       

        $department = $student->department;

        // Only fetch courses under student's department
        $courses = Course::where('department', $department)->get();

        $enrolled = $student->enrolledCourses->pluck('id')->toArray();

        return view('student.enroll', compact('courses', 'enrolled'));
    }

    // ✅ Handle form submission
    public function enroll(Request $request)
    {
        $request->validate([
            'courses' => 'array',
            'courses.*' => 'exists:courses,id'
        ]);

        $student = Auth::user()->student;

        $student->enrolledCourses()->sync($request->courses);

        return redirect()->route('student.dashboard')->with('success', 'Courses enrolled successfully!');
    }
}
