@extends('layouts.app')

@section('title', 'Edit Class Schedule')

@section('content')
<div class="container mt-4">
    <h2>Edit Schedule</h2>

    <form action="{{ route('lecturer.schedule.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" class="form-select" required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $schedule->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="day" class="form-label">Day</label>
            <select name="day" class="form-select" required>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" name="start_time" class="form-control" value="{{ $schedule->start_time }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" name="end_time" class="form-control" value="{{ $schedule->end_time }}" required>
        </div>

        <div class="mb-3">
            <label for="venue" class="form-label">Venue</label>
            <input type="text" name="venue" class="form-control" value="{{ $schedule->venue }}" required>
        </div>

        <button class="btn btn-primary">Update Schedule</button>
        <a href="{{ route('lecturer.schedule') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
