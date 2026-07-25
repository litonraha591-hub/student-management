@extends('layouts.app')
@section('title', 'Add Grade Rule')
@section('page-title', 'Add Grade Rule')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.grades.store') }}">@csrf
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label">Grade Name</label><input type="text" name="grade_name" class="form-control" value="{{ old('grade_name') }}" required placeholder="e.g. A+"></div>
            <div class="col-md-3"><label class="form-label">Min Marks</label><input type="number" name="min_marks" class="form-control" value="{{ old('min_marks') }}" step="0.01" required></div>
            <div class="col-md-3"><label class="form-label">Max Marks</label><input type="number" name="max_marks" class="form-control" value="{{ old('max_marks') }}" step="0.01" required></div>
            <div class="col-md-3"><label class="form-label">GPA</label><input type="number" name="gpa" class="form-control" value="{{ old('gpa') }}" step="0.01" min="0" max="4" required></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
