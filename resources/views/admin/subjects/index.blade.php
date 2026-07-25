@extends('layouts.app')
@section('title', 'Subjects')
@section('page-title', 'Subjects')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div></div>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Subject</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Name</th><th>Code</th><th>Class</th><th>Teacher</th><th>Total Marks</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($subjects as $s)
            <tr>
                <td>{{ $loop->iteration }}</td><td>{{ $s->name }}</td><td><span class="badge bg-info">{{ $s->code }}</span></td>
                <td>{{ $s->class->name ?? '-' }}</td><td>{{ $s->teacher?->name ?? '-' }}</td><td>{{ $s->total_marks }}</td>
                <td><a href="{{ route('admin.subjects.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('admin.subjects.destroy', $s) }}" class="d-inline">@csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div>
@endsection
