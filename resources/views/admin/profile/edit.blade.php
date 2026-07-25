@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Profile</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="photo" class="img-thumbnail mt-2" width="120">
                    @endif
                </div>

                <button class="btn btn-primary">Save Profile</button>
            </form>

            <hr>

            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <h5>Change Password</h5>

                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button class="btn btn-secondary">Change Password</button>
            </form>
        </div>

        <div class="col-md-6">
            <h4>Manage</h4>
            <ul class="list-group">
                <li class="list-group-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                <li class="list-group-item"><a href="{{ route('admin.teachers.index') }}">Teachers</a></li>
                <li class="list-group-item"><a href="{{ route('admin.subjects.index') }}">Subjects</a></li>
                <li class="list-group-item"><a href="{{ route('admin.classes.index') }}">Classes</a></li>
                <li class="list-group-item"><a href="{{ route('admin.departments.index') }}">Departments</a></li>
                <li class="list-group-item"><a href="{{ route('admin.academic-years.index') }}">Academic Years</a></li>
                <li class="list-group-item"><a href="{{ route('admin.exams.index') }}">Exams</a></li>
                <li class="list-group-item"><a href="{{ route('admin.fees.index') }}">Fees</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
