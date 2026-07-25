@extends('layouts.app')
@section('title', 'Exam Schedule')
@section('page-title', 'Schedule: ' . $exam->name)
@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Add Schedule</h6></div><div class="card-body">
            <form method="POST" action="{{ route('admin.exams.schedule.store', $exam) }}">@csrf
                <div class="row g-3">
                    <div class="col-6"><label class="form-label">Subject</label><select name="subject_id" class="form-select" required><option value="">Select</option>@foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
                    <div class="col-6"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
                    <div class="col-4"><label class="form-label">Date</label><input type="date" name="exam_date" class="form-control" required></div>
                    <div class="col-4"><label class="form-label">Start Time</label><input type="time" name="start_time" class="form-control" required></div>
                    <div class="col-4"><label class="form-label">End Time</label><input type="time" name="end_time" class="form-control" required></div>
                    <div class="col-6"><label class="form-label">Hall</label><input type="text" name="hall" class="form-control"></div>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-plus me-2"></i>Add</button>
            </form>
        </div></div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Schedule</h6></div><div class="card-body">
            @forelse($schedules as $s)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <div><strong>{{ $s->subject->name }}</strong> - {{ $s->class->name }}<br><small class="text-muted">{{ $s->exam_date->format('M d, Y') }} | {{ $s->start_time }} - {{ $s->end_time }} {{ $s->hall ? '| Hall: '.$s->hall : '' }}</small></div>
                <form method="POST" action="{{ route('admin.exams.schedule.destroy', $s) }}">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-times"></i></button>
                </form>
            </div>
            @empty <p class="text-muted text-center py-3">No schedule entries yet</p>
            @endforelse
        </div></div>
    </div>
</div>
@endsection
