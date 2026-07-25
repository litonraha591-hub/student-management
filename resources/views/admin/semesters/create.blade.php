@extends('layouts.app')
@section('title', 'Add Semester')
@section('page-title', 'Add Semester')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.semesters.store') }}">@csrf
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. Semester 1"></div>
            <div class="col-md-3"><label class="form-label">Academic Year</label><select name="academic_year_id" class="form-select" required><option value="">Select</option>@foreach($academicYears as $y)<option value="{{ $y->id }}">{{ $y->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required></div>
            <div class="col-md-3"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.semesters.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
