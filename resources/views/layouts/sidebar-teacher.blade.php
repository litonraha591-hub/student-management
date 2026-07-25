<a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
<div class="nav-section">Teaching</div>
<a href="{{ route('teacher.attendance.index') }}" class="nav-link {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}"><i class="fas fa-check-double"></i> Attendance</a>
<a href="{{ route('teacher.results.index') }}" class="nav-link {{ request()->routeIs('teacher.results.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Results</a>
<a href="{{ route('teacher.exams.index') }}" class="nav-link {{ request()->routeIs('teacher.exams.*') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> Exams</a>
<a href="{{ route('teacher.lesson-plans.index') }}" class="nav-link {{ request()->routeIs('teacher.lesson-plans.*') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Lesson Plans</a>
<a href="{{ route('teacher.routine.index') }}" class="nav-link {{ request()->routeIs('teacher.routine.*') ? 'active' : '' }}"><i class="fas fa-table"></i> Routine</a>
<a href="{{ route('teacher.assignments.index') }}" class="nav-link {{ request()->routeIs('teacher.assignments.*') ? 'active' : '' }}"><i class="fas fa-tasks"></i> Assignments</a>
<div class="nav-section">Account</div>
<a href="{{ route('teacher.profile.edit') }}" class="nav-link {{ request()->routeIs('teacher.profile.*') ? 'active' : '' }}"><i class="fas fa-user"></i> My Profile</a>
