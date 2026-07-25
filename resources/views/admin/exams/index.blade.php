@extends('layouts.app')
@section('title', 'Exams')
@section('page-title', 'Exams')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div></div>
    <a href="{{ route('admin.exams.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Exam</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Name</th><th>Type</th><th>Academic Year</th><th>Start</th><th>End</th><th>Actions</th></tr></thead>
        <tbody>@foreach($exams as $e)<tr>
            <td>{{ $loop->iteration }}</td><td>{{ $e->name }}</td><td><span class="badge bg-{{ $e->type == 'final' ? 'danger' : 'info' }}">{{ ucfirst($e->type) }}</span></td>
            <td>{{ $e->academicYear->name ?? '-' }}</td><td>{{ $e->start_date->format('M d, Y') }}</td><td>{{ $e->end_date->format('M d, Y') }}</td>
            <td><a href="{{ route('admin.exams.schedule', $e) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-calendar"></i></a>
                <a href="{{ route('admin.exams.edit', $e) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('admin.exams.destroy', $e) }}" class="d-inline">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
