<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\StudentRegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\LecturerController as AdminLecturerController;

// Landing Page (Login)
Route::get('/', fn () => view('auth.login'))->name('login');

// Student Registration
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');


// Dashboard Redirect Based on Role
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) return redirect()->route('login');

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'lecturer':
            return redirect()->route('lecturer.dashboard');
        case 'student':
            return redirect()->route('student.dashboard');
        default:
            Auth::logout();
            return redirect()->route('login')->withErrors(['role' => 'Unauthorized access.']);
    }
})->middleware(['auth'])->name('dashboard');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Dashboards
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/lecturer/dashboard', [LecturerController::class, 'index'])->name('lecturer.dashboard');
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {

        // Students
        Route::resource('students', \App\Http\Controllers\Admin\StudentController::class)
            ->except(['show'])
            ->names('students');
  
        // Lecturers
        Route::resource('lecturers', \App\Http\Controllers\Admin\LecturerController::class)
            ->except(['show'])
            ->names('lecturers');

        // Courses
        Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class)
            ->except(['show'])
            ->names('courses'); 

        // Departments
        Route::resource('departments', DepartmentController::class)
            ->except(['show'])
            ->names('departments');

        // Attendance Records
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');

        // QR Code Management
        Route::get('/qrcodes', [QRCodeController::class, 'index'])->name('qrcodes.index');
        Route::get('/qrcodes/{user}/download', [QRCodeController::class, 'download'])->name('qrcodes.download');
        Route::post('/qrcodes/{user}/regenerate', [QRCodeController::class, 'regenerate'])->name('qrcodes.regenerate');

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });
    // Lecturer Routes
    Route::prefix('lecturer')->name('lecturer.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [LecturerController::class, 'index'])->name('dashboard');

        // Courses
        Route::get('/courses', [LecturerController::class, 'courses'])->name('courses');

        // Schedule
        Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule'); // View all schedules
        Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create'); // Show form
        Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store'); // Save new schedule
        Route::get('/schedule/{id}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit'); // Edit form
        Route::put('/schedule/{id}', [ScheduleController::class, 'update'])->name('schedule.update'); // Update schedule
        Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy'); // Delete schedule

        // attendance
        Route::get('/attendance/scan', [LecturerController::class, 'scanAttendance'])->name('attendance.scan');
        Route::post('/attendance/mark', [LecturerController::class, 'markAttendance'])->name('attendance.mark');


        // Attendance Reports
        Route::get('/attendance/reports', [LecturerController::class, 'attendanceReports'])->name('attendance.reports');

        // Profile
        Route::get('/profile', [LecturerController::class, 'profile'])->name('profile');
    });
       
    // Student Routes
    Route::prefix('student')->name('student.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');

        // Course Enrollment
        Route::get('/courses/enroll', [StudentController::class, 'showEnrollmentForm'])->name('enroll.form');
        Route::post('/courses/enroll', [StudentController::class, 'enroll'])->name('enroll.submit');

        // (Optional future: Attendance, Profile, Reports, etc.)
    });


});

// Breeze Auth Routes
require __DIR__.'/auth.php';
