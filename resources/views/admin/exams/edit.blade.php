@extends('layouts.app')
@section('title', 'Edit Exam')
@section('page-title', 'Edit Exam')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.exams.update', $exam) }}">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name', $exam->name) }}" required></div>
            <div class="col-md-3"><label class="form-label">Type</label><select name="type" class="form-select" required><option value="quiz" {{ $exam->type == 'quiz' ? 'selected' : '' }}>Quiz</option><option value="assignment" {{ $exam->type == 'assignment' ? 'selected' : '' }}>Assignment</option><option value="mid" {{ $exam->type == 'mid' ? 'selected' : '' }}>Mid</option><option value="final" {{ $exam->type == 'final' ? 'selected' : '' }}>Final</option><option value="practical" {{ $exam->type == 'practical' ? 'selected' : '' }}>Practical</option></select></div>
            <div class="col-md-3"><label class="form-label">Academic Year</label><select name="academic_year_id" class="form-select" required><option value="">Select</option>@foreach($academicYears as $y)<option value="{{ $y->id }}" {{ $exam->academic_year_id == $y->id ? 'selected' : '' }}>{{ $y->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Semester</label><select name="semester_id" class="form-select"><option value="">Select</option>@foreach($semesters as $s)<option value="{{ $s->id }}" {{ $exam->semester_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date', $exam->start_date->format('Y-m-d')) }}" required></div>
            <div class="col-md-3"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-control" value="{{ old('end_date', $exam->end_date->format('Y-m-d')) }}" required></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button> <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
