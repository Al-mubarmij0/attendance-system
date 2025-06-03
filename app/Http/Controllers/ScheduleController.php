<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\Lecturer;

class ScheduleController extends Controller
{
    public function index()
    {
        // Correctly get the Lecturer model linked to the authenticated user
        $lecturer = Lecturer::where('user_id', auth()->id())->firstOrFail();

        // Fetch only schedules belonging to this lecturer
        $schedules = ClassSchedule::with('course')
            ->where('lecturer_id', $lecturer->id)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('lecturer.schedule.index', compact('schedules'));
    }

    public function create()
    {
        // Get lecturer's courses using relationship
        $lecturer = Lecturer::where('user_id', auth()->id())->firstOrFail();
        $courses = $lecturer->courses;

        return view('lecturer.schedule.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'venue' => 'required|string',
        ]);

        $lecturer = Lecturer::where('user_id', auth()->id())->firstOrFail();

        ClassSchedule::create([
            'lecturer_id' => $lecturer->id, // Correct lecturer_id
            'course_id' => $request->course_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'venue' => $request->venue,
        ]);

        return redirect()->route('lecturer.schedule')->with('success', 'Schedule created successfully.');
    }
}
