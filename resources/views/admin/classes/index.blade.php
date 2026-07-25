@extends('layouts.app')
@section('title', 'Classes')
@section('page-title', 'Classes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Class</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover" id="dataTable">
            <thead class="table-light"><tr><th>#</th><th>Name</th><th>Department</th><th>Sections</th><th>Subjects</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($classes as $class)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->department?->name ?? '-' }}</td>
                    <td>{{ $class->sections->count() }}</td>
                    <td>{{ $class->subjects->count() }}</td>
                    <td>
                        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" class="d-inline">@csrf @method('DELETE')
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
