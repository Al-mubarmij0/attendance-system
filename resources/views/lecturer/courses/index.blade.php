@extends('layouts.app') {{-- Extend your main application layout --}}

@section('header')
    {{-- Re-include your lecturer panel navigation for consistent header --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lecturer Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lecturer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('lecturer.courses') }}">Assigned Courses</a>
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">My Assigned Courses</h3>
        <a href="{{ route('lecturer.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    @if($courses->isEmpty())
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">No Courses Assigned!</h4>
            <p>It looks like you haven't been assigned any courses for this semester yet. Please contact the administration if you believe this is an error.</p>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">List of Your Courses</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Course Code</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Credits</th>
                                <th scope="col">Description</th>
                                {{-- Add other relevant course details here, e.g., 'Level', 'Semester' --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->department }}</td> {{-- Assuming 'department' column exists --}}
                                    <td>{{ $course->credits }}</td>
                                    <td>{{ $course->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
    {{-- You can include any page-specific JavaScript here,
         e.g., for data tables if you add pagination/search later. --}}
@endsection