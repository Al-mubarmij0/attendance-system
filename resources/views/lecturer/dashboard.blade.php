@extends('layouts.app')

@section('header')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lecturer Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('lecturer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lecturer.attendance.scan') }}">Mark Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lecturer.attendance.reports') }}">Attendance Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lecturer.profile') }}">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Assigned Courses -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Assigned Courses</h5>
                    <p class="card-text">View the list of courses assigned to you this semester.</p>
                    <a href="{{ route('lecturer.courses') }}" class="btn btn-primary">View Courses</a>                </div>
            </div>
        </div>

        <!-- Upcoming Class Schedules -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Classes</h5>
                    <p class="card-text">Check your upcoming schedule and class timings.</p>
                    <a href="{{ route('lecturer.schedule') }}" class="btn btn-primary">View Schedule</a>
                </div>
            </div>
        </div>

        <!-- Quick QR Scan -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Quick QR Scan</h5>
                    <p class="card-text">Launch scanner for quick student attendance marking.</p>
                    <a href="{{ route('lecturer.attendance.scan') }}" class="btn btn-success">Scan Now</a>
                </div>
            </div>
        </div>

        <!-- Attendance Report -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Attendance Reports</h5>
                    <p class="card-text">View, filter, and export attendance records for your courses.</p>
                    <a href="{{ route('lecturer.attendance.reports') }}" class="btn btn-info">View Reports</a>
                </div>
            </div>
        </div>

        <!-- Profile Page -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Your Profile</h5>
                    <p class="card-text">Manage your personal info and change your password.</p>
                    <a href="{{ route('lecturer.profile') }}" class="btn btn-secondary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
