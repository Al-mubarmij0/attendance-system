@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Student</h1>

    <form action="{{ route('admin.students.update', $student->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $student->email) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
    </form>
</div>
@endsection
