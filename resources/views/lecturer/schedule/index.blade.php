@extends('layouts.app')

@section('title', 'Class Schedule')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">My Class Schedule</h2>

    <a href="{{ route('lecturer.schedule.create') }}" class="btn btn-primary mb-3">+ Schedule a New Class</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($schedules->isEmpty())
        <p>No classes scheduled yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $index => $schedule)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $schedule->course->name }}</td>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                        <td>{{ $schedule->venue }}</td>
                        <td>
                            <a href="{{ route('lecturer.schedule.edit', $schedule->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('lecturer.schedule.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this schedule?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
