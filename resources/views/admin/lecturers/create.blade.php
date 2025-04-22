@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Add New Lecturer</h2>

    <form action="{{ route('admin.lecturers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>


        <div class="mb-3">
            <label for="staff_id" class="form-label">Staff ID</label>
            <input type="text" name="staff_id" class="form-control" required value="{{ old('staff_id') }}">
        </div>

        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" required value="{{ old('specialization') }}">
        </div>

        <div class="mb-3">
            <label for="bio" class="form-label">Biography</label>
            <textarea name="bio" class="form-control" rows="4">{{ old('bio') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Lecturer</button>
    </form>
</div>
@endsection
