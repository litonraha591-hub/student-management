@extends('layouts.app')
@section('title', 'Results')
@section('page-title', 'Results')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form method="GET" class="d-flex gap-2">
        <select name="exam_id" class="form-select" style="width:150px"><option value="">All Exams</option>@foreach($exams as $e)<option value="{{ $e->id }}" {{ request('exam_id') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>@endforeach</select>
        <select name="class_id" class="form-select" style="width:120px"><option value="">All Classes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select>
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.results.enter') }}" class="btn btn-primary"><i class="fas fa-pen me-2"></i>Enter Marks</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Student</th><th>Subject</th><th>Exam</th><th>Quiz</th><th>Assignment</th><th>Mid</th><th>Final</th><th>Total</th><th>GPA</th><th>Grade</th></tr></thead>
        <tbody>
            @foreach($marks as $m)
            <tr>
                <td>{{ $m->student->user->name ?? '-' }}</td><td>{{ $m->subject->name ?? '-' }}</td><td>{{ $m->exam->name ?? '-' }}</td>
                <td>{{ $m->quiz_marks }}</td><td>{{ $m->assignment_marks }}</td><td>{{ $m->mid_marks }}</td><td>{{ $m->final_marks }}</td>
                <td><strong>{{ $m->total_marks }}</strong></td><td>{{ $m->gpa ?? '-' }}</td>
                <td><span class="badge bg-primary">{{ $m->grade ?? '-' }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div>
@endsection
