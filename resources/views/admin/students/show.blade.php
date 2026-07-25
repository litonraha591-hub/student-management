@extends('layouts.app')
@section('title', 'Student Profile')
@section('page-title', 'Student Profile')

@section('content')
<div class="row g-4">
    <div class="col-xl-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <img src="{{ $student->user->photo_url }}" width="120" height="120" class="rounded-circle mb-3">
            <h5>{{ $student->user->name }}</h5>
            <span class="badge bg-primary mb-2">{{ $student->student_id }}</span>
            <p class="text-muted mb-1">{{ $student->class?->name }} - {{ $student->section?->name }}</p>
            <p class="text-muted">Roll: {{ $student->roll ?? 'N/A' }}</p>
            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-outline-primary"><i class="fas fa-edit me-2"></i>Edit Profile</a>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card shadow-sm border-0 mb-4"><div class="card-header bg-white"><h6 class="mb-0">Personal Details</h6></div><div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>Gender:</strong> {{ ucfirst($student->gender) }}</div>
                <div class="col-md-4"><strong>Blood Group:</strong> {{ $student->blood_group ?? '-' }}</div>
                <div class="col-md-4"><strong>Date of Birth:</strong> {{ $student->date_of_birth?->format('M d, Y') ?? '-' }}</div>
                <div class="col-md-4"><strong>Religion:</strong> {{ $student->religion ?? '-' }}</div>
                <div class="col-md-4"><strong>Email:</strong> {{ $student->user->email }}</div>
                <div class="col-md-4"><strong>Phone:</strong> {{ $student->user->phone ?? '-' }}</div>
                <div class="col-md-4"><strong>Father:</strong> {{ $student->father_name ?? '-' }}</div>
                <div class="col-md-4"><strong>Mother:</strong> {{ $student->mother_name ?? '-' }}</div>
                <div class="col-md-4"><strong>Guardian:</strong> {{ $student->guardian_name ?? '-' }}</div>
                <div class="col-md-4"><strong>Admission:</strong> {{ $student->admission_date->format('M d, Y') }}</div>
                <div class="col-md-4"><strong>Status:</strong> <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($student->status) }}</span></div>
            </div>
        </div></div>

        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Results</h6></div><div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Subject</th><th>Exam</th><th>Total</th><th>GPA</th><th>Grade</th></tr></thead>
                    <tbody>
                        @forelse($student->marks as $mark)
                        <tr><td>{{ $mark->subject->name }}</td><td>{{ $mark->exam->name }}</td><td>{{ $mark->total_marks }}</td><td>{{ $mark->gpa ?? '-' }}</td><td><span class="badge bg-primary">{{ $mark->grade ?? '-' }}</span></td></tr>
                        @empty <tr><td colspan="5" class="text-center text-muted">No results yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div></div>
    </div>
</div>
@endsection
