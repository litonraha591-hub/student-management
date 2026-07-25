@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('page-title', 'Teacher Dashboard')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card card-stat" style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff;">
        <div class="number">{{ $todayClasses->count() }}</div><div class="label text-white-50">Today's Classes</div>
    </div></div>
    <div class="col-md-3"><div class="card card-stat" style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: #fff;">
        <div class="number">{{ $todayAttendance }}</div><div class="label text-white-50">Attendance Marked</div>
    </div></div>
    <div class="col-md-3"><div class="card card-stat" style="background: linear-gradient(135deg, #fa709a, #fee140); color: #fff;">
        <div class="number">{{ $pendingAssignments }}</div><div class="label text-white-50">Active Assignments</div>
    </div></div>
</div>

<div class="row g-4">
    <div class="col-xl-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-calendar-day me-2"></i>Today's Schedule</h6></div><div class="card-body">
            @forelse($todayClasses as $c)
            <div class="d-flex align-items-center border-bottom py-2">
                <div class="bg-primary text-white rounded p-2 me-3" style="min-width:60px;text-align:center"><small>{{ $c->start_time }}</small></div>
                <div><strong>{{ $c->subject->name }}</strong><br><small class="text-muted">{{ $c->class->name }} - {{ $c->section->name }} @if($c->room) | Room: {{ $c->room }} @endif</small></div>
            </div>
            @empty <p class="text-muted text-center py-3">No classes today</p>
            @endforelse
        </div></div>
    </div>
    <div class="col-xl-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Recent Notices</h6></div><div class="card-body p-0">
            @forelse($recentNotices as $n)<div class="border-bottom px-3 py-2"><div class="fw-semibold small">{{ $n->title }}</div><small class="text-muted">{{ $n->created_at->diffForHumans() }}</small></div>
            @empty <p class="text-muted text-center py-3">No notices</p>@endforelse
        </div></div>
    </div>
</div>
@endsection
