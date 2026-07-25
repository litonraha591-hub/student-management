@extends('layouts.app')
@section('title', 'Add Department')
@section('page-title', 'Add Department')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.departments.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                <div class="col-md-4"><label class="form-label">Code</label><input type="text" name="code" class="form-control" value="{{ old('code') }}" required></div>
                <div class="col-md-4"><label class="form-label">Description</label><input type="text" name="description" class="form-control" value="{{ old('description') }}"></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
