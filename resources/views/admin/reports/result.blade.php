@extends('layouts.app')
@section('title', 'Result Report')
@section('page-title', 'Result Report')
@section('content')
<form method="GET" class="card shadow-sm border-0 p-3 mb-4"><div class="row g-3 align-items-end">
    <div class="col-md-3"><label class="form-label">Exam</label><select name="exam_id" class="form-select"><option value="">All</option>@foreach($exams as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach</select></div>
    <div class="col-md-3"><label class="form-label">Class</label><select name="class_id" class="form-select"><option value="">All</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-2"><button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button></div>
</div></form>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Student</th><th>Subject</th><th>Exam</th><th>Total</th><th>GPA</th><th>Grade</th></tr></thead>
        <tbody>@foreach($marks as $m)<tr><td>{{ $m->student->user->name ?? '-' }}</td><td>{{ $m->subject->name ?? '-' }}</td><td>{{ $m->exam->name ?? '-' }}</td>
            <td><strong>{{ $m->total_marks }}</strong></td><td>{{ $m->gpa ?? '-' }}</td><td><span class="badge bg-primary">{{ $m->grade ?? '-' }}</span></td></tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
