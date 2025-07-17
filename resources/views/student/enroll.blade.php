@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Enroll in Courses</h4>

    <form action="{{ route('student.enroll.submit') }}" method="POST">
        @csrf
        <div class="row">
            @forelse($courses as $course)
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input class="form-check-input"
                            type="checkbox"
                            name="courses[]"
                            value="{{ $course->id }}"
                            id="course{{ $course->id }}"
                            {{ in_array($course->id, $enrolled) ? 'checked' : '' }}>
                        <label class="form-check-label" for="course{{ $course->id }}">
                            <strong>{{ $course->code }}</strong> - {{ $course->name }}
                        </label>
                    </div>
                </div>
            @empty
                <p>No courses available for your department.</p>
            @endforelse
        </div>
        <button type="submit" class="btn btn-primary">Submit Enrollment</button>
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
@endsection
