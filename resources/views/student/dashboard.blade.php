@extends('layouts.app')

@section('header')
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Student Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('student.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My QR Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Welcome back, {{ $user->name }}!</h4>
                            {{-- Now accessing student-specific data via the $studentProfile object --}}
                            <p class="text-muted mb-0">Student ID: {{ $studentProfile->index_number ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Department:</strong> {{ $studentProfile->department ?? 'N/A' }}</p>
                        
                        </div>
                        <div class="text-end">
                            <p class="mb-0"><strong>Level:</strong> {{ $studentProfile->level ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Attendance Summary</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="mb-0">Overall Attendance Rate</p>
                            <h2 class="mb-0">87%</h2> {{-- Replace with dynamic data later --}}
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                        </div>
                    </div>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <a href="#" class="btn btn-outline-primary">View Details</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Your QR Code</h5>
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/qrcodes/'.$user->id.'.png') }}" alt="QR Code" style="width: 150px; height: 150px;" class="img-fluid">
                    </div>
                    <p class="card-text">Present this QR code to mark your attendance in class.</p>
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-primary">View Full QR</a>
                        <a href="{{ asset('storage/qrcodes/'.$user->id.'.png') }}" download class="btn btn-outline-secondary">Download</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Your Current Courses</h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Lecturer</th>
                                    <th>Schedule</th>
                                    <th>Attendance Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrolledCourses as $course)
                                <tr>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->name }}</td>
                                    {{-- Access lecturer via Course model's lecturer relationship, then lecturer's user name --}}
                                    <td>{{ $course->lecturer->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($course->classSchedules->isNotEmpty())
                                            {{ $course->classSchedules->count() }} classes scheduled
                                        @else
                                            No schedules
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Placeholder for dynamic attendance rate --}}
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">N/A</div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">You are not currently enrolled in any courses.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Classes</h5>
                    <div class="list-group">
                        @forelse($upcomingSchedules as $schedule)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    {{ $schedule->course->code }} - {{ $schedule->course->name }}
                                </h6>
                                {{-- Make sure Carbon is imported in your layout or use full namespace --}}
                                <small class="{{ Carbon\Carbon::parse($schedule->class_date)->isToday() ? 'text-success' : (Carbon\Carbon::parse($schedule->class_date)->isTomorrow() ? 'text-primary' : '') }}">
                                    {{ Carbon\Carbon::parse($schedule->class_date)->calendar() }}
                                </small>
                            </div>
                            <p class="mb-1">
                                {{ Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                                {{ Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                            </p>
                            <small>
                                Room: {{ $schedule->location ?? 'N/A' }} |
                                Lecturer: {{ $schedule->lecturer->name ?? 'N/A' }}
                            </small>
                            @if($schedule->notes)
                                <p class="mb-0 mt-1"><small class="text-muted">Notes: {{ $schedule->notes }}</small></p>
                            @endif
                        </div>
                        @empty
                        <div class="list-group-item text-muted">
                            No upcoming classes found for your enrolled courses.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Recent Attendance</h5>
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">CS201 - Data Structures</h6>
                                <small class="text-success">Present</small>
                            </div>
                            <p class="mb-1">May 18, 2023 | 01:00 PM</p>
                            <small>Scanned by Prof. Johnson</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">CS101 - Introduction to Programming</h6>
                                <small class="text-success">Present</small>
                            </div>
                            <p class="mb-1">May 17, 2023 | 10:00 AM</p>
                            <small>Scanned by Dr. Smith</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">MATH202 - Discrete Mathematics</h6>
                                <small class="text-danger">Absent</small>
                            </div>
                            <p class="mb-1">May 12, 2023 | 09:00 AM</p>
                            <small>No scan recorded</small>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-primary mt-3">View All Records</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection