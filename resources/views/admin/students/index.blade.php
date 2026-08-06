@extends('layouts.app')
@section('title', 'Students')
@section('page-title', 'Students')
@section('content')

@php
$unassignedCount = $students->where('class_id', null)->count() + $students->where('section_id', null)->count();
@endphp

@if($unassignedCount > 0)
<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Attention:</strong> {{ $unassignedCount }} student(s) are not yet assigned to a class/shift. They won't be able to see their attendance, results, assignments, and lesson plans until assigned.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search by name, ID, roll..." value="{{ request('search') }}">
        <select name="class_id" class="form-select" style="width:150px"><option value="">All Classes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select>
        <select name="status" class="form-select" style="width:120px"><option value="">All Status</option><option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option><option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option></select>
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Student</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable">
            <thead class="table-light"><tr><th>#</th><th>Photo</th><th>Student ID</th><th>Name</th><th>Class</th><th>Shift</th><th>Roll</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($students as $student)
                <tr class="{{ (!$student->class_id || !$student->section_id) ? 'table-warning' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ $student->user->photo_url }}" width="36" height="36" class="rounded-circle"></td>
                    <td><span class="badge bg-primary">{{ $student->student_id }}</span></td>
                    <td>
                        {{ $student->user->name }}
                        @if(!$student->class_id || !$student->section_id)
                        <span class="badge bg-danger ms-2" title="Not assigned to class/shift"><i class="fas fa-exclamation-circle"></i> Unassigned</span>
                        @endif
                    </td>
                    <td>{{ $student->class?->name ?? '-' }}</td>
                    <td>{{ $student->section?->name ?? '-' }}</td>
                    <td>{{ $student->roll ?? '-' }}</td>
                    <td><span class="badge bg-{{ $student->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($student->status) }}</span></td>
                    <td>
                        <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-primary" {{ (!$student->class_id || !$student->section_id) ? 'title="REQUIRED: Click to assign class and shift"' : '' }}><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" class="d-inline">@csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $students->withQueryString()->links('vendor.pagination.bootstrap-5-no-icons') }}
    </div>
</div></div>
@endsection
