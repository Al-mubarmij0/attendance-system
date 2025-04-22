@extends('layouts.app')

@section('header')
    <div class="text-center mt-4">
        <h2 class="h4 fw-bold text-dark">Welcome Back</h2>
        <p class="text-muted">Please sign in to continue</p>
    </div>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4 fw-bold">Login to Your Account</h2>

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required
                    class="form-control @error('password') is-invalid @enderror" placeholder="********">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="small text-decoration-none">
                        Forgot your password?
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
