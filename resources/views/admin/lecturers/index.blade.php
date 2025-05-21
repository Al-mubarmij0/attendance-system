@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h3>Lecturer Management</h3>
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addLecturerModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Lecturer
            </button>
        </div>

        {{-- Success/Error Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        {{-- Validation Errors for the modal form --}}
        @if ($errors->any() && session('open_add_lecturer_modal'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="lecturersTable">
                        <thead class="table-light">
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
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.lecturers.edit', $lecturer->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger delete-lecturer" data-id="{{ $lecturer->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">
            {{ $lecturers->links() }}
        </div>
    </div>

    {{-- Add Lecturer Modal --}}
    <div class="modal fade" id="addLecturerModal" tabindex="-1" aria-labelledby="addLecturerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.lecturers.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLecturerModalLabel">Add New Lecturer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="staff_id" class="form-label">Staff ID</label>
                            <input type="text" class="form-control @error('staff_id') is-invalid @enderror" id="staff_id" name="staff_id" value="{{ old('staff_id') }}" required>
                            @error('staff_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization') }}" required>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NEW: Assign Courses Select --}}
                        <div class="mb-3">
                            <label for="assigned_courses" class="form-label">Assign Courses</label>
                            {{-- `allCourses` is passed from the index method of LecturerController --}}
                            <select class="form-select @error('assigned_courses') is-invalid @enderror" id="assigned_courses_add_modal" name="assigned_courses[]" multiple>
                                <option value="">Select courses to assign...</option> {{-- Placeholder option --}}
                                @foreach($allCourses as $course)
                                    <option value="{{ $course->id }}"
                                        {{-- old('assigned_courses') is for re-populating after validation error --}}
                                        {{ in_array($course->id, old('assigned_courses', [])) ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->code }})
                                        @if($course->lecturer)
                                            - (Currently: {{ $course->lecturer->user->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_courses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Lecturer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Ensure jQuery, DataTables, Bootstrap JS, and Select2 JS/CSS are loaded --}}
    {{-- Assuming they are loaded in layouts.admin or via CDN in your project --}}
    {{-- If not, ensure you have these:
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    --}}
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#lecturersTable').DataTable({
                responsive: true
            });

            // Initialize Select2 for the ADD modal
            $('#assigned_courses_add_modal').select2({
                placeholder: 'Select courses to assign...',
                allowClear: true,
                dropdownParent: $('#addLecturerModal') // Important for modals
            });

            // Delete lecturer confirmation (using AJAX like your courses table)
            $('.delete-lecturer').click(function() {
                const lecturerId = $(this).data('id');
                if (confirm('Are you sure you want to delete this lecturer? This will also unassign them from any courses.')) {
                    $.ajax({
                        url: `/admin/lecturers/${lecturerId}`,
                        type: 'POST', // Use POST for Laravel's DELETE method with _method field
                        data: {
                            '_token': '{{ csrf_token() }}',
                            '_method': 'DELETE' // Spoof DELETE method
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload(); // Reload page to reflect changes
                            } else {
                                alert('Error deleting lecturer: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred during deletion.');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Handle displaying validation errors in the modal after redirect
            @if ($errors->any() && session('open_add_lecturer_modal'))
                var addLecturerModal = new bootstrap.Modal(document.getElementById('addLecturerModal'));
                addLecturerModal.show();
            @endif
        });
    </script>
@endsection