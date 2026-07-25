<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

<div class="nav-section">Academic</div>
<a href="{{ route('admin.academic-years.index') }}" class="nav-link {{ request()->routeIs('admin.academic-years.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> Academic Years</a>
<a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"><i class="fas fa-building"></i> Departments</a>
<a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}"><i class="fas fa-chalkboard"></i> Classes</a>
<a href="{{ route('admin.sections.index') }}" class="nav-link {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}"><i class="fas fa-layer-group"></i> Shifts</a>
<a href="{{ route('admin.subjects.index') }}" class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}"><i class="fas fa-book"></i> Subjects</a>
<a href="{{ route('admin.semesters.index') }}" class="nav-link {{ request()->routeIs('admin.semesters.*') ? 'active' : '' }}"><i class="fas fa-clock"></i> Semesters</a>

<div class="nav-section">People</div>
<a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"><i class="fas fa-user-graduate"></i> Students</a>
<a href="{{ route('admin.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}"><i class="fas fa-chalkboard-teacher"></i> Teachers</a>

<div class="nav-section">Academics</div>
<a href="{{ route('admin.routines.index') }}" class="nav-link {{ request()->routeIs('admin.routines.*') ? 'active' : '' }}"><i class="fas fa-table"></i> Routine</a>
<a href="{{ route('admin.attendance.index') }}" class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}"><i class="fas fa-check-double"></i> Attendance</a>
<a href="{{ route('admin.exams.index') }}" class="nav-link {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> Exams</a>
<a href="{{ route('admin.results.index') }}" class="nav-link {{ request()->routeIs('admin.results.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Results</a>
<a href="{{ route('admin.grades.index') }}" class="nav-link {{ request()->routeIs('admin.grades.*') ? 'active' : '' }}"><i class="fas fa-star"></i> Grade System</a>

<div class="nav-section">Communication</div>
<a href="{{ route('admin.notices.index') }}" class="nav-link {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}"><i class="fas fa-bullhorn"></i> Notices</a>
<a href="{{ route('admin.assignments.index') }}" class="nav-link {{ request()->routeIs('admin.assignments.*') ? 'active' : '' }}"><i class="fas fa-tasks"></i> Assignments</a>

<div class="nav-section">Finance</div>
<a href="{{ route('admin.fees.index') }}" class="nav-link {{ request()->routeIs('admin.fees.*') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Fees</a>

<div class="nav-section">Reports</div>
<a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="fas fa-chart-pie"></i> Reports</a>
