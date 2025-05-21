@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h3>Edit Course: {{ $course->name }}</h3>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Courses
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="courseCode" class="form-label">Course Code</label>
                        <input type="text" class="form-control" id="courseCode" name="code" value="{{ $course->code }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="courseName" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="courseName" name="name" value="{{ $course->name }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department" name="department" required>
                            <option value="Computer Science" {{ $course->department == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                            <option value="Engineering" {{ $course->department == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Business" {{ $course->department == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="Arts" {{ $course->department == 'Arts' ? 'selected' : '' }}>Arts</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="credits" class="form-label">Credit Hours</label>
                        <input type="number" class="form-control" id="credits" name="credits" min="1" max="6" value="{{ $course->credits }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $course->description }}</textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection