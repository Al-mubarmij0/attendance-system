@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manage Students</h1>
        <a href="{{ route('admin.students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Student</a>
    </div>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr class="text-left">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $student)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $student->name }}</td>
                    <td class="px-4 py-2">{{ $student->email }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this student?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
