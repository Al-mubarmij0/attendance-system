@extends('layouts.app')

@section('title', 'Schedule a Class')

@section('content')
<div class="container mt-4">
    <h2>Schedule a New Class</h2>

    <form action="{{ route('lecturer.schedule.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" id="course_id" class="form-select" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="day" class="form-label">Day</label>
            <select name="day" class="form-select" required>
                <option value="">-- Select Day --</option>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="venue" class="form-label">Venue</label>
            <input type="text" name="venue" class="form-control" required>
        </div>

        <button class="btn btn-success">Create Schedule</button>
        <a href="{{ route('lecturer.schedule') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
