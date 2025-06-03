<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\ClassSchedule;
use App\Models\Student; // Crucial: We need to import the Student model now

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

}