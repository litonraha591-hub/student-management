@extends('layouts.app')
@section('title', 'Teacher Profile')
@section('page-title', 'Teacher Profile')
@section('content')
<div class="row g-4">
    <div class="col-xl-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <img src="{{ $teacher->user->photo_url }}" width="120" height="120" class="rounded-circle mb-3">
            <h5>{{ $teacher->user->name }}</h5>
            <span class="badge bg-info mb-2">{{ $teacher->employee_id }}</span>
            <p class="text-muted">{{ $teacher->designation ?? 'Teacher' }}</p>
            <div class="d-grid gap-2 mt-3"><a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-2"></i>Edit</a></div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card shadow-sm border-0 mb-4"><div class="card-header bg-white"><h6 class="mb-0">Details</h6></div><div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>Email:</strong> {{ $teacher->user->email }}</div>
                <div class="col-md-4"><strong>Phone:</strong> {{ $teacher->user->phone ?? '-' }}</div>
                <div class="col-md-4"><strong>Qualification:</strong> {{ $teacher->qualification ?? '-' }}</div>
                <div class="col-md-4"><strong>Specialization:</strong> {{ $teacher->specialization ?? '-' }}</div>
                <div class="col-md-4"><strong>Joining Date:</strong> {{ $teacher->joining_date?->format('M d, Y') ?? '-' }}</div>
            </div>
        </div></div>
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Assigned Subjects</h6></div><div class="card-body">
            <table class="table table-sm"><thead><tr><th>Subject</th><th>Class</th></tr></thead>
            <tbody>@forelse($subjects as $s)<tr><td>{{ $s->name }}</td><td>{{ $s->class->name }}</td></tr>@empty <tr><td colspan="2" class="text-muted">No subjects assigned</td></tr>@endforelse</tbody></table>
        </div></div>
    </div>
</div>
@endsection
