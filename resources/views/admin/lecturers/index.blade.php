@extends('layouts.admin')

@section('content')
<h2>Manage Lecturers</h2>

<a href="{{ route('admin.lecturers.create') }}" class="btn btn-primary mb-3">Add Lecturer</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Staff ID</th>
            <th>Specialization</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lecturers as $index => $lecturer)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $lecturer->user->name }}</td>
            <td>{{ $lecturer->user->email }}</td>
            <td>{{ $lecturer->staff_id }}</td>
            <td>{{ $lecturer->specialization }}</td>
            <td>
                <a href="{{ route('admin.lecturers.edit', $lecturer) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.lecturers.destroy', $lecturer) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $lecturers->links() }}
@endsection
