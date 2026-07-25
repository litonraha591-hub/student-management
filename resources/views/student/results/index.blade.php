@extends('layouts.app')
@section('title', 'My Results')
@section('page-title', 'My Results')
@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex align-items-center justify-content-between">
        <div><h5 class="mb-0">Overall GPA: <span class="text-primary">{{ number_format($gpa, 2) }}</span></h5><small class="text-muted">Based on {{ $marks->where('gpa', '!=', null)->count() }} graded subjects</small></div>
    </div>
</div>

@foreach($exams as $examId => $examMarks)
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">{{ $examMarks->first()->exam->name ?? 'Exam' }}</h6>
        <a href="{{ route('student.results.marksheet', $examId) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-print me-1"></i>Marksheet</a>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead><tr><th>Subject</th><th>Quiz</th><th>Assignment</th><th>Mid</th><th>Final</th><th>Total</th><th>GPA</th><th>Grade</th></tr></thead>
            <tbody>@foreach($examMarks as $m)<tr>
                <td>{{ $m->subject->name }}</td><td>{{ $m->quiz_marks }}</td><td>{{ $m->assignment_marks }}</td><td>{{ $m->mid_marks }}</td><td>{{ $m->final_marks }}</td>
                <td><strong>{{ $m->total_marks }}</strong></td><td>{{ $m->gpa ?? '-' }}</td>
                <td><span class="badge bg-primary">{{ $m->grade ?? '-' }}</span></td>
            </tr>@endforeach</tbody>
        </table>
    </div>
</div>
@endforeach

@if($marks->isEmpty())
<div class="alert alert-info">No results available yet.</div>
@endif
@endsection
