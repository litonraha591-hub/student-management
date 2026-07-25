@extends('layouts.app')
@section('title', 'Attendance Report')
@section('page-title', 'Attendance Report')
@section('content')
<form method="GET" class="card shadow-sm border-0 p-3 mb-4"><div class="row g-3 align-items-end">
    <div class="col-md-3"><label class="form-label">Class</label><select name="class_id" class="form-select"><option value="">All</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-3"><label class="form-label">Month</label><input type="month" name="month" class="form-control" value="{{ request('month') }}"></div>
    <div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button></div>
</div></form>
<div class="row g-3 mb-4">
    <div class="col"><div class="card text-center p-3"><h4 class="text-primary mb-0">{{ $summary['total'] }}</h4><small>Total Records</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-success mb-0">{{ $summary['present'] }}</h4><small>Present</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-danger mb-0">{{ $summary['absent'] }}</h4><small>Absent</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-warning mb-0">{{ $summary['late'] }}</h4><small>Late</small></div></div>
    <div class="col"><div class="card text-center p-3"><h4 class="text-info mb-0">{{ $summary['leave'] }}</h4><small>Leave</small></div></div>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Date</th><th>Student</th><th>Subject</th><th>Status</th></tr></thead>
        <tbody>@foreach($attendances as $a)<tr><td>{{ $a->date->format('M d, Y') }}</td><td>{{ $a->student->user->name ?? '-' }}</td><td>{{ $a->subject->name ?? '-' }}</td>
            <td><span class="badge bg-{{ $a->status == 'present' ? 'success' : ($a->status == 'absent' ? 'danger' : ($a->status == 'late' ? 'warning' : 'info')) }}">{{ ucfirst($a->status) }}</span></td></tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
