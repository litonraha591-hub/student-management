@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Edit Profile</h6></div><div class="card-body">
            <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
                <div class="mb-3"><img src="{{ $user->photo_url }}" width="80" height="80" class="rounded-circle mb-2"></div>
                <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
                <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ $user->phone }}"></div>
                <div class="mb-3"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
            </form>
        </div></div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Change Password</h6></div><div class="card-body">
            <form method="POST" action="{{ route('teacher.profile.password') }}">@csrf @method('PUT')
                <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
                <button type="submit" class="btn btn-warning"><i class="fas fa-key me-2"></i>Change Password</button>
            </form>
        </div></div>
    </div>
</div>
@endsection
