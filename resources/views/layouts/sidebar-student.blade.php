<a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
<div class="nav-section">My Studies</div>
<a href="{{ route('student.attendance.index') }}" class="nav-link {{ request()->routeIs('student.attendance.*') ? 'active' : '' }}"><i class="fas fa-check-double"></i> Attendance</a>
<a href="{{ route('student.results.index') }}" class="nav-link {{ request()->routeIs('student.results.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Results</a>
<a href="{{ route('student.assignments.index') }}" class="nav-link {{ request()->routeIs('student.assignments.*') ? 'active' : '' }}"><i class="fas fa-tasks"></i> Assignments</a>
<a href="{{ route('student.lesson-plans.index') }}" class="nav-link {{ request()->routeIs('student.lesson-plans.*') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Lesson Plans</a>
<div class="nav-section">Account</div>
<a href="{{ route('student.profile.edit') }}" class="nav-link {{ request()->routeIs('student.profile.*') ? 'active' : '' }}"><i class="fas fa-user"></i> My Profile</a>
