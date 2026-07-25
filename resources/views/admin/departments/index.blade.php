@extends('layouts.app')
@section('title', 'Departments')
@section('page-title', 'Departments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.departments.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Department</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover" id="dataTable">
            <thead class="table-light">
                <tr><th>#</th><th>Name</th><th>Code</th><th>Description</th><th>Classes</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dept->name }}</td>
                    <td><span class="badge bg-primary">{{ $dept->code }}</span></td>
                    <td>{{ Str::limit($dept->description ?? '', 50) }}</td>
                    <td>{{ $dept->classes_count }}</td>
                    <td>
                        <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" class="d-inline">@csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No departments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
