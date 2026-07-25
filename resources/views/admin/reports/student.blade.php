@extends('layouts.app')
@section('title', 'Student Report')
@section('page-title', 'Student Report')
@section('content')
<form method="GET" class="card shadow-sm border-0 p-3 mb-4"><div class="row g-3 align-items-end">
    <div class="col-md-3"><label class="form-label">Class</label><select name="class_id" class="form-select"><option value="">All</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button></div>
</div></form>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>ID</th><th>Name</th><th>Class</th><th>Shift</th><th>Status</th><th>Admission</th></tr></thead>
        <tbody>@foreach($students as $s)<tr><td>{{ $loop->iteration }}</td><td>{{ $s->student_id }}</td><td>{{ $s->user->name }}</td><td>{{ $s->class?->name }}</td><td>{{ $s->section?->name }}</td>
            <td><span class="badge bg-{{ $s->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($s->status) }}</span></td><td>{{ $s->admission_date->format('M d, Y') }}</td></tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
