@extends('layouts.app')
@section('title', 'Attendance Reports')
@section('page-title', 'Attendance Reports')
@section('content')
<form method="GET" class="card shadow-sm border-0 p-3 mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-2"><label class="form-label">Class</label><select name="class_id" class="form-select"><option value="">All</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Shift</label><select name="section_id" class="form-select"><option value="">All</option>@foreach($sections as $s)<option value="{{ $s->id }}" {{ request('section_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Subject</label><select name="subject_id" class="form-select"><option value="">All</option>@foreach($subjects as $s)<option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Date</label><input type="date" name="date" class="form-control" value="{{ request('date') }}"></div>
        <div class="col-md-2"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option><option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option><option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option><option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option><option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Leave</option></select></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Filter</button></div>
    </div>
</form>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Date</th><th>Student</th><th>Class</th><th>Shift</th><th>Subject</th><th>Status</th></tr></thead>
        <tbody>
            @foreach($attendances as $a)
            <tr><td>{{ $a->date->format('M d, Y') }}</td><td>{{ $a->student->user->name ?? '-' }}</td><td>{{ $a->class->name ?? '-' }}</td><td>{{ $a->section->name ?? '-' }}</td><td>{{ $a->subject->name ?? '-' }}</td>
                <td><span class="badge bg-{{ $a->status == 'present' ? 'success' : ($a->status == 'absent' ? 'danger' : ($a->status == 'late' ? 'warning' : 'info')) }}">{{ ucfirst($a->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div>
@endsection
