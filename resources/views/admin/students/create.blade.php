@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Add New Student</h1>

    <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Create</button>
    </form>
</div>
@endsection
