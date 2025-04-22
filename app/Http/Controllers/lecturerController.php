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
        $lecturer = Auth::user(); // assuming the authenticated user is the lecturer

        return view('lecturer.dashboard', compact('lecturer'));
    }

    /**
     * Show the list of courses assigned to the lecturer.
     */
    public function courses()
    {
        $lecturer = Auth::user();
        // Assuming you have a method to fetch assigned courses, for example:
        $courses = $lecturer->courses; // Fetch courses associated with the lecturer

        return view('lecturer.courses', compact('courses'));
    }

    /**
     * Show the lecturer's schedule.
     */
    public function schedule()
    {
        $lecturer = Auth::user();
        // Assuming you have a method to fetch the schedule
        $schedule = $lecturer->schedule; // Fetch the lecturer's schedule

        return view('lecturer.schedule', compact('schedule'));
    }

    /**
     * Display the QR code scanner for attendance marking.
     */
    public function scanAttendance()
    {
        // Here you can integrate a QR code scanner for attendance
        return view('lecturer.attendance.scan');
    }

    /**
     * Show the attendance reports for the lecturer's courses.
     */
    public function attendanceReports()
    {
        $lecturer = Auth::user();
        // Assuming you have a method to fetch attendance reports, for example:
        $attendanceReports = $lecturer->attendanceReports; // Fetch attendance reports

        return view('lecturer.attendance.reports', compact('attendanceReports'));
    }

    /**
     * Show the lecturer's profile page.
     */
    public function profile()
    {
        $lecturer = Auth::user(); // Get the logged-in lecturer's information

        return view('lecturer.profile', compact('lecturer'));
    }
}
