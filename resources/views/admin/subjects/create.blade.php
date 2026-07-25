@extends('layouts.app')
@section('title', 'Add Subject')
@section('page-title', 'Add Subject')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.subjects.store') }}">@csrf
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
            <div class="col-md-3"><label class="form-label">Code</label><input type="text" name="code" class="form-control" value="{{ old('code') }}" required></div>
            <div class="col-md-3"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Total Marks</label><input type="number" name="total_marks" class="form-control" value="{{ old('total_marks', 100) }}" required></div>
            <div class="col-md-6"><label class="form-label">Teacher</label><select name="teacher_id" class="form-select"><option value="">Select</option>@foreach($teachers as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach</select></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
