@extends('layouts.app')
@section('title', 'Student Result')
@section('page-title', 'Student Result - ' . $student->user->name)
@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center gap-4">
            <img src="{{ $student->user->photo_url }}" width="80" height="80" class="rounded-circle">
            <div><h4>{{ $student->user->name }}</h4><p class="text-muted mb-0">{{ $student->student_id }} | {{ $student->class?->name }} - {{ $student->section?->name }}</p></div>
            <div class="ms-auto text-center"><h2 class="text-primary mb-0">{{ number_format($totalGpa, 2) }}</h2><small class="text-muted">CGPA</small></div>
        </div>
    </div>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover">
        <thead class="table-light"><tr><th>Subject</th><th>Exam</th><th>Quiz</th><th>Assignment</th><th>Mid</th><th>Final</th><th>Total</th><th>GPA</th><th>Grade</th></tr></thead>
        <tbody>@foreach($marks as $m)<tr><td>{{ $m->subject->name }}</td><td>{{ $m->exam->name }}</td><td>{{ $m->quiz_marks }}</td><td>{{ $m->assignment_marks }}</td><td>{{ $m->mid_marks }}</td><td>{{ $m->final_marks }}</td><td><strong>{{ $m->total_marks }}</strong></td><td>{{ $m->gpa ?? '-' }}</td><td><span class="badge bg-primary">{{ $m->grade ?? '-' }}</span></td></tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
