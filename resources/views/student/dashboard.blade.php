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
                            <h4 class="mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
                            <p class="text-muted mb-0">Student ID: {{ Auth::user()->student_id }}</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0"><strong>Current Semester:</strong> Spring 2023</p>
                            <p class="mb-0"><strong>Program:</strong> Computer Science</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Attendance Summary -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Attendance Summary</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="mb-0">Overall Attendance Rate</p>
                            <h2 class="mb-0">87%</h2>
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

        <!-- QR Code Card -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Your QR Code</h5>
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/qrcodes/'.Auth::user()->id.'.png') }}" alt="QR Code" style="width: 150px; height: 150px;" class="img-fluid">
                    </div>
                    <p class="card-text">Present this QR code to mark your attendance in class.</p>
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-primary">View Full QR</a>
                        <a href="{{ asset('storage/qrcodes/'.Auth::user()->id.'.png') }}" download class="btn btn-outline-secondary">Download</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Courses -->
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
                                <tr>
                                    <td>CS101</td>
                                    <td>Introduction to Programming</td>
                                    <td>Dr. Smith</td>
                                    <td>Mon/Wed 10:00-11:30</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100">92%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CS201</td>
                                    <td>Data Structures</td>
                                    <td>Prof. Johnson</td>
                                    <td>Tue/Thu 13:00-14:30</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">78%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>MATH202</td>
                                    <td>Discrete Mathematics</td>
                                    <td>Dr. Williams</td>
                                    <td>Fri 09:00-12:00</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 95%;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">95%</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Classes -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Classes</h5>
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">CS101 - Introduction to Programming</h6>
                                <small class="text-success">Today</small>
                            </div>
                            <p class="mb-1">10:00 AM - 11:30 AM</p>
                            <small>Room: CS-101</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">MATH202 - Discrete Mathematics</h6>
                                <small class="text-primary">Tomorrow</small>
                            </div>
                            <p class="mb-1">09:00 AM - 12:00 PM</p>
                            <small>Room: MATH-302</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">CS201 - Data Structures</h6>
                                <small>Wed, May 24</small>
                            </div>
                            <p class="mb-1">01:00 PM - 02:30 PM</p>
                            <small>Room: CS-205</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Attendance -->
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