@extends('layouts.app')
@section('title', 'Add Fee')
@section('page-title', 'Add Fee Structure')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <form method="POST" action="{{ route('admin.fees.store') }}">@csrf
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
            <div class="col-md-3"><label class="form-label">Type</label><select name="type" class="form-select" required><option value="admission">Admission</option><option value="monthly">Monthly</option><option value="exam">Exam</option><option value="other">Other</option></select></div>
            <div class="col-md-3"><label class="form-label">Amount</label><input type="number" name="amount" class="form-control" value="{{ old('amount') }}" step="0.01" required></div>
            <div class="col-md-3"><label class="form-label">Class</label><select name="class_id" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Academic Year</label><select name="academic_year_id" class="form-select" required><option value="">Select</option>@foreach($academicYears as $y)<option value="{{ $y->id }}">{{ $y->name }}</option>@endforeach</select></div>
        </div>
        <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.fees.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
