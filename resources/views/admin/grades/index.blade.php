@extends('layouts.app')
@section('title', 'Grade System')
@section('page-title', 'Grade System')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div></div>
    <a href="{{ route('admin.grades.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Grade Rule</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover">
        <thead class="table-light"><tr><th>#</th><th>Grade</th><th>Min Marks</th><th>Max Marks</th><th>GPA</th><th>Actions</th></tr></thead>
        <tbody>@foreach($grades as $g)<tr>
            <td>{{ $loop->iteration }}</td><td><span class="badge bg-primary fs-6">{{ $g->grade_name }}</span></td>
            <td>{{ $g->min_marks }}</td><td>{{ $g->max_marks }}</td><td>{{ $g->gpa }}</td>
            <td><a href="{{ route('admin.grades.edit', $g) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('admin.grades.destroy', $g) }}" class="d-inline">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
