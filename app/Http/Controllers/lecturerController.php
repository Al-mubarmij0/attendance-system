<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class LecturerController extends Controller
{
    /**
     * Display the lecturer dashboard.
     */
    public function index()
    {
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;
        $assignedCourses = collect();

        if ($lecturer) {
            $assignedCourses = $lecturer->courses;
        }

        return view('lecturer.dashboard', compact('user', 'lecturer', 'assignedCourses'));
    }

    /**
     * Display courses assigned to the lecturer.
     */
    public function courses()
    {
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;
        $courses = collect();

        if ($lecturer) {
            $courses = $lecturer->courses()->orderBy('name')->get();
        }

        return view('lecturer.courses.index', compact('courses'));
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
        $attendanceReports = collect();

        if ($lecturer) {
            // Implement logic here to fetch attendance reports via courses if needed.
            // Example: $attendanceReports = $lecturer->courses->flatMap(fn($course) => $course->attendances);
        }

        return view('lecturer.attendance.reports', compact('attendanceReports'));
    }

    /**
     * Display the lecturer's profile information.
     */
    public function profile()
    {
        $user = Auth::user()->load('lecturer');
        $lecturer = $user->lecturer;

        return view('lecturer.profile', compact('user', 'lecturer'));
    }
}
