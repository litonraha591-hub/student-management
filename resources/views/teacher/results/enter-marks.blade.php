@extends('layouts.app')
@section('title', 'Enter Marks')
@section('page-title', 'Enter Marks')
@section('content')
<form method="GET" class="card shadow-sm border-0 p-3 mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-2"><label class="form-label">Exam</label><select name="exam_id" class="form-select" required><option value="">Select</option>@foreach($exams as $e)<option value="{{ $e->id }}" {{ request('exam_id') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Shift</label><select name="section_id" class="form-select" required><option value="">Select</option>@foreach($sections as $s)<option value="{{ $s->id }}" {{ request('section_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Subject</label><select name="subject_id" class="form-select" required><option value="">Select</option>@foreach($subjects as $s)<option value="{{ $s->id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Load</button></div>
    </div>
</form>

@if($students->count() > 0)
<form method="POST" action="{{ route('teacher.results.save') }}">@csrf
    <input type="hidden" name="exam_id" value="{{ request('exam_id') }}">
    <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
    <input type="hidden" name="class_id" value="{{ request('class_id') }}">
    <input type="hidden" name="section_id" value="{{ request('section_id') }}">
    <div class="card shadow-sm border-0"><div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary"><tr><th>#</th><th>Student</th><th>Quiz (20)</th><th>Assignment (10)</th><th>Mid (30)</th><th>Final (40)</th></tr></thead>
                <tbody>@foreach($students as $i => $item)<tr>
                    <td>{{ $i + 1 }}</td><td>{{ $item['student']->user->name }}<input type="hidden" name="marks[{{ $i }}][student_id]" value="{{ $item['student']->id }}"></td>
                    <td><input type="number" name="marks[{{ $i }}][quiz_marks]" class="form-control form-control-sm" value="{{ $item['mark']->quiz_marks ?? '' }}" min="0" max="20" step="0.5"></td>
                    <td><input type="number" name="marks[{{ $i }}][assignment_marks]" class="form-control form-control-sm" value="{{ $item['mark']->assignment_marks ?? '' }}" min="0" max="10" step="0.5"></td>
                    <td><input type="number" name="marks[{{ $i }}][mid_marks]" class="form-control form-control-sm" value="{{ $item['mark']->mid_marks ?? '' }}" min="0" max="30" step="0.5"></td>
                    <td><input type="number" name="marks[{{ $i }}][final_marks]" class="form-control form-control-sm" value="{{ $item['mark']->final_marks ?? '' }}" min="0" max="40" step="0.5"></td>
                </tr>@endforeach</tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary btn-lg mt-3"><i class="fas fa-save me-2"></i>Save Marks</button>
    </div></div>
</form>
@endif
@endsection
