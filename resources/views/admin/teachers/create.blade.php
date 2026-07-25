@extends('layouts.app')
@section('title', 'Add Teacher')
@section('page-title', 'Add Teacher')
@section('content')
<form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">@csrf
<div class="card shadow-sm border-0 mb-4"><div class="card-header bg-primary text-white"><i class="fas fa-chalkboard-teacher me-2"></i>Teacher Information</div><div class="card-body">
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="col-md-4"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
        <div class="col-md-4"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Confirm Password *</label><input type="password" name="password_confirmation" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
        <div class="col-md-4"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
        <div class="col-md-4"><label class="form-label">Designation</label><input type="text" name="designation" class="form-control" value="{{ old('designation') }}"></div>
        <div class="col-md-4"><label class="form-label">Qualification</label><input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}"></div>
        <div class="col-md-4"><label class="form-label">Specialization</label><input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}"></div>
        <div class="col-md-4"><label class="form-label">Joining Date</label><input type="date" name="joining_date" class="form-control" value="{{ old('joining_date') }}"></div>
        <div class="col-md-8"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="1">{{ old('address') }}</textarea></div>
    </div>
</div></div>
<div class="d-flex gap-2"><button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Save</button> <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary btn-lg">Cancel</a></div>
</form>
@endsection
