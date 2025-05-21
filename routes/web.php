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
use App\Http\Controllers\Admin\LecturerController as AdminLecturerController;

// Landing Page (Login)
Route::get('/', fn () => view('auth.login'))->name('login');

// Student Registration
Route::get('/register', [StudentRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [StudentRegisterController::class, 'register'])->name('register.submit');

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
        Route::resource('students', AdminController::class)
            ->parameters(['students' => 'student'])
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
        Route::get('/schedule', [LecturerController::class, 'schedule'])->name('schedule'); // View all schedules
        Route::get('/schedule/create', [LecturerController::class, 'createSchedule'])->name('schedule.create'); // Show form
        Route::post('/schedule', [LecturerController::class, 'storeSchedule'])->name('schedule.store'); // Save new schedule
        Route::get('/schedule/{id}/edit', [LecturerController::class, 'editSchedule'])->name('schedule.edit'); // Edit form
        Route::put('/schedule/{id}', [LecturerController::class, 'updateSchedule'])->name('schedule.update'); // Update schedule
        Route::delete('/schedule/{id}', [LecturerController::class, 'destroySchedule'])->name('schedule.destroy'); // Delete schedule

        // Attendance Scan (QR)
        Route::get('/attendance/scan', [LecturerController::class, 'scanAttendance'])->name('attendance.scan');

        // Attendance Reports
        Route::get('/attendance/reports', [LecturerController::class, 'attendanceReports'])->name('attendance.reports');

        // Profile
        Route::get('/profile', [LecturerController::class, 'profile'])->name('profile');
    });

});

// Breeze Auth Routes
require __DIR__.'/auth.php';
