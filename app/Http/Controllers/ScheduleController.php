<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // app/Http/Controllers/Lecturer/ScheduleController.php

public function index()
{
    $lecturerId = auth()->user()->id; // Assuming lecturers are authenticated users

    $schedules = Schedule::with('course')
        ->where('lecturer_id', $lecturerId)
        ->orderBy('day')
        ->orderBy('start_time')
        ->get();

    return view('lecturer.schedule.index', compact('schedules'));
}

}
