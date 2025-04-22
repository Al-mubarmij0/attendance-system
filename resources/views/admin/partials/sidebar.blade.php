<div class="bg-dark text-white p-3" style="min-height: 100vh; width: 250px;">
    <h5 class="text-warning mb-4"><i class="bi bi-person-workspace me-2"></i> Admin Panel</h5>

    <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-house-door-fill me-2 text-warning"></i> Dashboard
            </a>
        </li>

        <!-- User Management -->
        <li class="nav-item mb-2">
            <span class="text-muted small">👥 User Management</span>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.students.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.students.*') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-people-fill me-2 text-success"></i> Manage Students
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.lecturers.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.lecturers.*') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-person-badge-fill me-2 text-warning"></i> Manage Lecturers
            </a>
        </li>

        <!-- Course Management -->
        <li class="nav-item mt-3 mb-2">
            <span class="text-muted small">📚 Course Management</span>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.courses.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.courses.*') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i> Courses
            </a>
        </li>

        <!-- Semester & Level -->
        <li class="nav-item mt-3 mb-2">
            <span class="text-muted small">🗓️ Semester & Level</span>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.semesters.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.semesters.*') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-calendar-event-fill me-2 text-danger"></i> Semesters
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.levels.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.levels.*') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-layers-fill me-2 text-info"></i> Levels
            </a>
        </li>

        <!-- Attendance -->
        <li class="nav-item mt-3 mb-2">
            <span class="text-muted small">📊 Attendance</span>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.attendance.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.attendance.*') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-clipboard-data-fill me-2 text-success"></i> Attendance Records
            </a>
        </li>

        <!-- QR Code -->
        <li class="nav-item mt-3 mb-2">
            <span class="text-muted small">🔐 QR Code</span>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.qrcodes.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.qrcodes.*') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-qr-code-scan me-2 text-light"></i> QR Code Management
            </a>
        </li>

        <!-- Settings -->
        <li class="nav-item mt-3 mb-2">
            <span class="text-muted small">⚙️ Settings</span>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('admin.settings') }}"
               class="nav-link text-white {{ request()->routeIs('admin.settings') ? 'bg-secondary rounded' : '' }}">
                <i class="bi bi-gear-fill me-2 text-info"></i> Settings
            </a>
        </li>
    </ul>
</div>
