@extends('layouts.app')
@section('title', 'Create Assignment')
@section('page-title', 'Create Assignment')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.assignments.store') }}" enctype="multipart/form-data">@csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="{{ old('title') }}" required></div>
            <div class="col-md-3"><label class="form-label">Subject</label><select name="subject_id" class="form-select" required><option value="">Select</option>@foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Deadline</label><input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required></div>
            <div class="col-md-4"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Shift</label><select name="section_id" class="form-select" required><option value="">Select</option>@foreach($sections as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Attachment</label><input type="file" name="attachment" class="form-control"></div>
            <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Create</button> <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
