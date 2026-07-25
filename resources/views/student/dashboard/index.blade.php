@extends('layouts.app')
@section('title', 'Student Dashboard')
@section('page-title', 'Student Dashboard')
@section('content')
@if($student)

@if(!$student->class_id || !$student->section_id)
<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Setup Required:</strong> Your profile is not yet assigned to a class and shift. Please contact your administrator to complete your enrollment. Once assigned, you'll see your attendance, results, assignments, and lesson plans here.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ $attendancePercentage }}%</div><div class="label text-white-50">Attendance</div></div>
                <div class="icon" style="background: rgba(255,255,255,0.2);"><i class="fas fa-check-double"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ number_format($gpa, 2) }}</div><div class="label text-white-50">GPA</div></div>
                <div class="icon" style="background: rgba(255,255,255,0.2);"><i class="fas fa-star"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ $subjects->count() }}</div><div class="label text-white-50">Subjects</div></div>
                <div class="icon" style="background: rgba(255,255,255, 0.2);"><i class="fas fa-book"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat" style="background: linear-gradient(135deg, #fa709a, #fee140); color: #fff;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="number">{{ $todayClasses->count() }}</div><div class="label text-white-50">Today's Classes</div></div>
                <div class="icon" style="background: rgba(255,255,255,0.2);"><i class="fas fa-calendar-day"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white border-0 p-4">
                <h6 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>My Profile</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ $student->user->photo_url }}" width="80" height="80" class="rounded-circle mb-3">
                <h5 class="mb-1">{{ $student->user->name }}</h5>
                <span class="badge bg-primary mb-3">{{ strtoupper($student->student_id) }}</span>
                <div class="text-start small">
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Class</span><strong>{{ $student->class?->name ?? '-' }}</strong></div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Shift</span><strong>{{ $student->section?->name ?? '-' }}</strong></div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Roll No</span><strong>{{ $student->roll ?? '-' }}</strong></div>
                    <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">Father</span><strong>{{ $student->father_name ?? '-' }}</strong></div>
                    <div class="d-flex justify-content-between py-2"><span class="text-muted">Year</span><strong>{{ $student->academicYear?->name ?? '-' }}</strong></div>
                </div>
                <a href="{{ route('student.profile.edit') }}" class="btn btn-outline-primary btn-sm mt-3"><i class="fas fa-edit me-1"></i>View Full Profile</a>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white border-0 p-4">
                <h6 class="mb-0"><i class="fas fa-calendar-day me-2 text-success"></i>Today's Classes</h6>
            </div>
            <div class="card-body p-0">
                @forelse($todayClasses as $c)
                <div class="d-flex align-items-center border-bottom px-4 py-3">
                    <div class="bg-light rounded p-2 me-3 text-center" style="min-width:65px;">
                        <small class="fw-bold">{{ $c->start_time }}</small>
                    </div>
                    <div>
                        <strong>{{ $c->subject->name }}</strong>
                        <br><small class="text-muted">{{ $c->teacher->name ?? '' }} | {{ $c->room ?? '' }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                    No classes scheduled for today
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2 text-warning"></i>Recent Results</h6>
                @if($recentMarks->count() > 0)
                    <a href="{{ route('student.results.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead style="background:#f8fafc;">
                            <tr><th class="ps-3">Subject</th><th>Exam</th><th>Total</th><th class="pe-3">Grade</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentMarks as $m)
                            <tr>
                                <td class="ps-3">{{ $m->subject->name }}</td>
                                <td><small>{{ $m->exam->name }}</small></td>
                                <td><strong>{{ $m->total_marks }}</strong></td>
                                <td class="pe-3"><span class="badge bg-primary">{{ $m->grade ?? '-' }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No results yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white border-0 p-4">
                <h6 class="mb-0"><i class="fas fa-bullhorn me-2 text-danger"></i>Recent Notices</h6>
            </div>
            <div class="card-body p-0">
                @forelse($recentNotices as $n)
                <div class="border-bottom px-4 py-3">
                    <div class="fw-semibold">{{ $n->title }}</div>
                    <small class="text-muted">{{ $n->content }}</small>
                    <br><small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $n->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-bell-slash fa-2x mb-2 d-block"></i>
                    No notices available
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-header bg-white border-0 p-4">
                <h6 class="mb-0"><i class="fas fa-book me-2 text-info"></i>My Subjects</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead style="background:#f8fafc;">
                            <tr><th class="ps-3">Subject</th><th>Code</th><th class="pe-3">Teacher</th></tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $subject)
                            <tr>
                                <td class="ps-3"><strong>{{ $subject->name }}</strong></td>
                                <td><span class="badge bg-light text-dark">{{ $subject->code }}</span></td>
                                <td class="pe-3">{{ $subject->teacher->name ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">No subjects assigned</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-body text-center py-5">
        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
        <h5>Your student profile is not yet set up.</h5>
        <p class="text-muted">Please contact the administrator to complete your registration.</p>
    </div>
</div>
@endif
@endsection
