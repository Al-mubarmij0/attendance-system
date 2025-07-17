<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

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
        $todayAttendanceCount = 0;

        if ($lecturer) {
            $assignedCourses = $lecturer->courses;

            // Count today's attendance entries for lecturer's courses
            $todayAttendanceCount = Attendance::whereIn('course_id', $assignedCourses->pluck('id'))
                ->whereDate('created_at', Carbon::today())
                ->count();
        }

        return view('lecturer.dashboard', compact('user', 'lecturer', 'assignedCourses', 'todayAttendanceCount'));
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
            // Optionally fetch or compute attendance summaries here
            // e.g. $attendanceReports = $lecturer->courses->flatMap(fn($c) => $c->attendances);
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

    /**
     * Handle marking of attendance via scanned QR/barcode.
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $lecturer = Auth::user()->lecturer;

        // Ensure course belongs to lecturer
        if (!$lecturer->courses->pluck('id')->contains($request->course_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized for this course.'
            ], 403);
        }

        // Check if attendance already marked today
        $alreadyMarked = Attendance::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if ($alreadyMarked) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already marked today.'
            ]);
        }

        // Create attendance record
        Attendance::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'marked_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully.'
        ]);
    }
}
