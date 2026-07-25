@extends('layouts.app')
@section('title', 'Edit Class')
@section('page-title', 'Edit Class')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.classes.update', $class) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name', $class->name) }}" required></div>
                <div class="col-md-6"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">Select</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ $class->department_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach</select></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button> <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
