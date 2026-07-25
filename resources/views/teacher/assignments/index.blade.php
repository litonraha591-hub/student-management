@extends('layouts.app')
@section('title', 'My Assignments')
@section('page-title', 'My Assignments')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div></div>
    <a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Create Assignment</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Title</th><th>Subject</th><th>Class</th><th>Deadline</th><th>Actions</th></tr></thead>
        <tbody>@foreach($assignments as $a)<tr><td>{{ $loop->iteration }}</td><td>{{ $a->title }}</td><td>{{ $a->subject->name ?? '-' }}</td><td>{{ $a->class->name ?? '-' }} - {{ $a->section->name ?? '-' }}</td><td>{{ $a->deadline->format('M d, Y') }}</td>
            <td><a href="{{ route('teacher.assignments.show', $a) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                <form method="POST" action="{{ route('teacher.assignments.destroy', $a) }}" class="d-inline">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                </form>
            </td></tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
