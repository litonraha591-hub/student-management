@extends('layouts.app')
@section('title', 'Shifts')
@section('page-title', 'Shifts')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Shift</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover" id="dataTable">
            <thead class="table-light"><tr><th>#</th><th>Name</th><th>Class</th><th>Teacher</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($sections as $section)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $section->name }}</td>
                    <td>{{ $section->class->name ?? '-' }}</td>
                    <td>{{ $section->teacher?->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.sections.destroy', $section) }}" class="d-inline">@csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
