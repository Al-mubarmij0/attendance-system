<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    /**
     * Display the lecturer dashboard.
     */
    public function index()
    {
        $lecturer = Auth::user();

        return view('lecturer.dashboard', compact('lecturer'));
    }

    /**
     * Display courses assigned to the lecturer.
     */
    public function courses()
    {
        $lecturer = Auth::user();

        // Ensure lecturer has a relationship defined as `courses()`
        $courses = $lecturer->courses ?? [];

        return view('lecturer.courses', compact('courses'));
    }

    /**
     * Display the lecturer's schedule.
     */
    public function schedule()
    {
        $lecturer = Auth::user();

        // Ensure lecturer has a relationship defined as `schedule()`
        $schedule = $lecturer->schedule ?? [];

        return view('lecturer.schedule', compact('schedule'));
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
        $lecturer = Auth::user();

        // Ensure lecturer has a method or relationship to get attendance reports
        $attendanceReports = $lecturer->attendanceReports ?? [];

        return view('lecturer.attendance.reports', compact('attendanceReports'));
    }

    /**
     * Display the lecturer's profile information.
     */
    public function profile()
    {
        $lecturer = Auth::user();

        return view('lecturer.profile', compact('lecturer'));
    }
}
