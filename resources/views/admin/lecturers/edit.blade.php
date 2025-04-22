@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Lecturer</h2>

    <form action="{{ route('admin.lecturers.update', $lecturer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $lecturer->user->name ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $lecturer->user->email ?? '') }}">
        </div>

         <!-- Password (optional) -->
        <input type="password" name="password" placeholder="New Password (leave blank to keep current)">
        <input type="password" name="password_confirmation" placeholder="Confirm New Password">

        <div class="mb-3">
            <label for="staff_id" class="form-label">Staff ID</label>
            <input type="text" name="staff_id" class="form-control" required value="{{ old('staff_id', $lecturer->staff_id) }}">
        </div>

        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" required value="{{ old('specialization', $lecturer->specialization) }}">
        </div>

        <div class="mb-3">
            <label for="bio" class="form-label">Biography</label>
            <textarea name="bio" class="form-control" rows="4">{{ old('bio', $lecturer->bio) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Lecturer</button>
    </form>
</div>
@endsection
