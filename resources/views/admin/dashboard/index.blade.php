@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ $totalStudents }}</div><div class="label text-white-50">Total Students</div></div>
                <div class="icon" style="background: rgba(255,255,255,0.2);"><i class="fas fa-user-graduate"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ $totalTeachers }}</div><div class="label text-white-50">Total Teachers</div></div>
                <div class="icon" style="background: rgba(255,255,255,0.2);"><i class="fas fa-chalkboard-teacher"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ $totalClasses }}</div><div class="label text-white-50">Classes</div></div>
                <div class="icon" style="background: rgba(255,255,255,0.2);"><i class="fas fa-chalkboard"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ $totalSubjects }}</div><div class="label text-white-50">Subjects</div></div>
                <div class="icon" style="background: rgba(255,255,255,0.2);"><i class="fas fa-book"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number text-primary">{{ $totalSections }}</div><div class="label">Shifts</div></div>
                <div class="icon" style="background: #eef2ff;"><i class="fas fa-layer-group text-primary"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat shadow-sm">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number text-success">{{ $todayAttendance }}</div><div class="label">Today's Attendance</div></div>
                <div class="icon" style="background: #ecfdf5;"><i class="fas fa-check-double text-success"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Monthly Attendance Overview</h6>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0"><i class="fas fa-bullhorn me-2 text-warning"></i>Recent Notices</h6>
            </div>
            <div class="card-body p-0">
                @forelse($recentNotices as $notice)
                <div class="border-bottom px-3 py-2">
                    <div class="fw-semibold small">{{ $notice->title }}</div>
                    <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <div class="text-center text-muted py-4">No notices yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const ctx = document.getElementById('attendanceChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json(array_column($monthlyAttendance, 'month')),
        datasets: [
            { label: 'Present', data: @json(array_column($monthlyAttendance, 'present')), backgroundColor: '#43e97b', borderRadius: 6 },
            { label: 'Absent', data: @json(array_column($monthlyAttendance, 'absent')), backgroundColor: '#f5576c', borderRadius: 6 },
            { label: 'Late', data: @json(array_column($monthlyAttendance, 'late')), backgroundColor: '#ffbe0b', borderRadius: 6 }
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection
