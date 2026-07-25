@extends('layouts.app')
@section('title', 'Add Shift')
@section('page-title', 'Add Shift')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.sections.store') }}">@csrf
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
            <div class="col-md-4"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Class Teacher</label><select name="teacher_id" class="form-select"><option value="">Select</option></select></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
