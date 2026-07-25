@extends('layouts.app')
@section('title', 'Add Routine')
@section('page-title', 'Add Routine Entry')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.routines.store') }}">@csrf
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Shift</label><select name="section_id" class="form-select" required><option value="">Select</option>@foreach($sections as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Subject</label><select name="subject_id" class="form-select" required><option value="">Select</option>@foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Teacher ID</label><input type="number" name="teacher_id" class="form-control" required placeholder="User ID"></div>
            <div class="col-md-3"><label class="form-label">Day</label><select name="day" class="form-select" required>@foreach(['saturday','sunday','monday','tuesday','wednesday','thursday','friday'] as $d)<option value="{{ $d }}">{{ ucfirst($d) }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Start Time</label><input type="time" name="start_time" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">End Time</label><input type="time" name="end_time" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Room</label><input type="text" name="room" class="form-control"></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.routines.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
