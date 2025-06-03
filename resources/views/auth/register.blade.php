@extends('layouts.app')

@section('header')
    <div class="text-center mt-4">
        <h2 class="h4 fw-bold text-dark">Join Our Community</h2>
        <p class="text-muted">Register as a student to get started</p>
    </div>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4 fw-bold">Student Registration</h2>
        <p class="text-center text-primary fw-bold mb-4">Only Student Can Register</p>

        {{-- Display general session messages (like success/error from controller) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="full_name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter your full name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="matric_number">Matric Number</label>
                <input type="text" class="form-control" name="matric_number" required>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control" name="department" required>
            </div>

            <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control" name="level" required>
                    <option value="100">100 Level</option>
                    <option value="200">200 Level</option>
                    <option value="300">300 Level</option>
                    <option value="400">400 Level</option>
                </select>
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="********">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4"> {{-- Changed to mb-4 to match login --}}
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="form-control" placeholder="********">
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>

            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('login') }}">
                    Already registered?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection