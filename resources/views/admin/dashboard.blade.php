@extends('layouts.admin')

@section('content')
<div class="d-flex min-vh-100">
    <!-- Main Content Area -->
    <div class="flex-grow-1 bg-light">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
            <div class="container-fluid justify-content-between">
                <span class="navbar-brand fw-semibold text-primary fs-4">Admin Dashboard</span>

                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/images/user-placeholder.png" alt="User Avatar" class="rounded-circle me-2" width="32" height="32">
                        <span class="text-dark small">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.settings') }}">Settings</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="container py-4">
            <h2 class="fw-bold mb-4 text-dark">Dashboard Overview</h2>

            <div class="row g-4">
                <div class="col-md-4">
                    <x-admin.stat-card title="Total Students" count="{{ $totalStudents }}" color="primary" />
                </div>
                <div class="col-md-4">
                    <x-admin.stat-card title="Total Lecturers" count="{{ $totalLecturers }}" color="success" />
                </div>
                <div class="col-md-4">
                    <x-admin.stat-card title="Total Courses" count="{{ $totalCourses }}" color="info" />
                </div>
                <div class="col-md-4">
                    <x-admin.stat-card title="Pending Students" count="{{ $pendingRegistrations }}" color="danger" />
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-dark text-center py-3 mt-auto text-white small">
            © 2025 Admin Panel | All Rights Reserved
        </footer>
    </div>
</div>
@endsection
