@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h3>Edit Lecturer: {{ $lecturer->user->name ?? 'N/A' }}</h3>
        <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Lecturers
        </a>
    </div>

    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.lecturers.update', $lecturer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $lecturer->user->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $lecturer->user->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="staff_id" class="form-label">Staff ID</label>
                        <input type="text" class="form-control @error('staff_id') is-invalid @enderror" id="staff_id" name="staff_id" value="{{ old('staff_id', $lecturer->staff_id) }}" required>
                        @error('staff_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization', $lecturer->specialization) }}" required>
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password (optional)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    <small class="form-text text-muted">Leave blank to keep current password.</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Biography</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $lecturer->bio) }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NEW: Assign Courses Select for EDIT page --}}
                <div class="mb-3">
                    <label for="assigned_courses" class="form-label">Assign Courses</label>
                    {{-- `allCourses` is passed from the edit method of LecturerController --}}
                    <select class="form-select @error('assigned_courses') is-invalid @enderror" id="assigned_courses_edit_page" name="assigned_courses[]" multiple>
                        <option value="">Select courses to assign...</option> {{-- Placeholder option --}}
                        @foreach($allCourses as $course)
                            <option value="{{ $course->id }}"
                                {{-- Check if this course is currently assigned to this lecturer (for initial selection) --}}
                                {{-- Or if it was selected via old() input after a validation error --}}
                                {{ (in_array($course->id, old('assigned_courses', $lecturer->courses->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->code }})
                                @if($course->lecturer && $course->lecturer->id !== $lecturer->id)
                                    - (Currently: {{ $course->lecturer->user->name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_courses')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Lecturer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Ensure jQuery, Select2 JS/CSS are loaded. --}}
    {{-- If not already in your layout, add them here:
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    --}}
    <script>
        $(document).ready(function() {
            // Initialize Select2 for the EDIT page
            $('#assigned_courses_edit_page').select2({
                placeholder: 'Select courses to assign...',
                allowClear: true
            });
        });
    </script>
@endsection