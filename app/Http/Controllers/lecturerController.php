<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
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
        $courses = $lecturer->courses ?? [];

        return view('lecturer.courses', compact('courses'));
    }

    /**
     * Display the lecturer's schedule.
     */
    public function schedule()
    {
        $lecturer = Auth::user();
        $schedules = $lecturer->schedules ?? [];

        return view('lecturer.schedule.index', compact('schedules'));
    }

    /**
     * Show form to create a new class schedule.
     */
    public function createSchedule()
    {
        $lecturer = Auth::user();
        $courses = $lecturer->courses ?? [];

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

        $lecturer = Auth::user();

        $lecturer->schedules()->create([
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
        $lecturer = Auth::user();
        $schedule = $lecturer->schedules()->findOrFail($id);
        $courses = $lecturer->courses ?? [];

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

        $lecturer = Auth::user();
        $schedule = $lecturer->schedules()->findOrFail($id);

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
        $lecturer = Auth::user();
        $schedule = $lecturer->schedules()->findOrFail($id);
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
        $lecturer = Auth::user();
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
