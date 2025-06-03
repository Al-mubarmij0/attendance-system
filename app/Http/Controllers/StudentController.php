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

        // Ensure the authenticated user has a student profile
        // If they don't, return a view with empty data or redirect
        if (!$user->isStudent() || !$user->student) {
            return view('student.dashboard', [
                'user' => $user,
                'studentProfile' => null, // No student profile available
                'enrolledCourses' => collect(), // Empty collection
                'upcomingSchedules' => collect(), // Empty collection
            ]);
        }

        // Get the Student profile associated with the authenticated User
        $studentProfile = $user->student;

        // Get the courses the logged-in student is enrolled in
        // This relationship is now on the Student model
        $enrolledCourses = $studentProfile->enrolledCourses;

        $upcomingSchedules = collect(); // Initialize as an empty collection

        if ($enrolledCourses->isNotEmpty()) {
            // Get all course IDs the student is offering
            $offeredCourseIds = $enrolledCourses->pluck('id');

            // Fetch class schedules for those courses, ordered by date and time
            $upcomingSchedules = ClassSchedule::whereIn('course_id', $offeredCourseIds)
                                    ->where('class_date', '>=', now()->toDateString()) // Only future/current schedules
                                    ->orderBy('class_date')
                                    ->orderBy('start_time')
                                    ->with('course', 'lecturer') // Eager load course and lecturer (User) for display
                                    ->get();
        }

        // Pass the user, student profile, enrolled courses, and schedules to the dashboard view
        return view('student.dashboard', compact('user', 'studentProfile', 'enrolledCourses', 'upcomingSchedules'));
    }
}