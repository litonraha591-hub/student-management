@extends('layouts.app')
@section('title', 'Teachers')
@section('page-title', 'Teachers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form method="GET" class="d-flex gap-2"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"><button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button></form>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Teacher</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Photo</th><th>Employee ID</th><th>Name</th><th>Designation</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($teachers as $t)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><img src="{{ $t->user->photo_url }}" width="36" height="36" class="rounded-circle"></td>
                <td><span class="badge bg-info">{{ $t->employee_id }}</span></td>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->designation ?? '-' }}</td>
                <td>{{ $t->user->email }}</td>
                <td>
                    <a href="{{ route('admin.teachers.show', $t) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.teachers.edit', $t) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('admin.teachers.destroy', $t) }}" class="d-inline">@csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div>
@endsection
