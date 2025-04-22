@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Attendance Reports</h1>
    <ul>
        @forelse ($attendanceReports as $report)
            <li>{{ $report->course->name ?? 'Unknown Course' }} - {{ $report->date }} - Present: {{ $report->present_count }}</li>
        @empty
            <li>No reports available.</li>
        @endforelse
    </ul>
</div>
@endsection
