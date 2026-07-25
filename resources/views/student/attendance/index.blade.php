@extends('layouts.app')
@section('title', 'My Attendance')
@section('page-title', 'My Attendance')
@section('content')

<div class="row g-3 mb-4">
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff;">
            <h3 class="mb-0">{{ $percentage }}%</h3>
            <small class="text-white-50">Overall Attendance</small>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h4 class="text-success mb-0">{{ $presentDays }}</h4>
            <small class="text-muted">Present</small>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h4 class="text-danger mb-0">{{ $absentDays }}</h4>
            <small class="text-muted">Absent</small>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h4 class="text-warning mb-0">{{ $lateDays }}</h4>
            <small class="text-muted">Late</small>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h4 class="text-info mb-0">{{ $leaveDays }}</h4>
            <small class="text-muted">Leave</small>
        </div>
    </div>
</div>

<form method="GET" class="card border-0 shadow-sm p-3 mb-4" style="border-radius:12px;">
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold">Filter by Month</label>
            <input type="month" name="month" class="form-control" value="{{ request('month') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button>
            @if(request('month'))
                <a href="{{ route('student.attendance.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </div>
    </div>
</form>

<div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-header bg-white border-0 p-4">
        <h6 class="mb-0"><i class="fas fa-history me-2 text-primary"></i>Attendance Record</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f0f4ff;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Subject</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $i => $a)
                    <tr>
                        <td class="ps-4">{{ $attendances->firstItem() + $i }}</td>
                        <td><strong>{{ $a->date->format('M d, Y') }}</strong></td>
                        <td>{{ $a->date->format('l') }}</td>
                        <td>{{ $a->subject->name ?? '-' }}</td>
                        <td>
                            @if($a->status == 'present')
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Present</span>
                            @elseif($a->status == 'absent')
                                <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Absent</span>
                            @elseif($a->status == 'late')
                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Late</span>
                            @else
                                <span class="badge bg-info"><i class="fas fa-minus-circle me-1"></i>Leave</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-check fa-2x mb-2 d-block"></i>
                            No attendance records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
