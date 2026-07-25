@extends('layouts.app')
@section('title', 'Edit Subject')
@section('page-title', 'Edit Subject')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}" required></div>
            <div class="col-md-3"><label class="form-label">Code</label><input type="text" name="code" class="form-control" value="{{ old('code', $subject->code) }}" required></div>
            <div class="col-md-3"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ $subject->class_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Total Marks</label><input type="number" name="total_marks" class="form-control" value="{{ old('total_marks', $subject->total_marks) }}" required></div>
            <div class="col-md-6"><label class="form-label">Teacher</label><select name="teacher_id" class="form-select"><option value="">Select</option>@foreach($teachers as $t)<option value="{{ $t->id }}" {{ $subject->teacher_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>@endforeach</select></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button> <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
