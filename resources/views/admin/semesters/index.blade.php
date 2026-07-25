@extends('layouts.app')
@section('title', 'Semesters')
@section('page-title', 'Semesters')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div></div>
    <a href="{{ route('admin.semesters.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Semester</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Name</th><th>Academic Year</th><th>Start</th><th>End</th><th>Current</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($semesters as $s)
            <tr><td>{{ $loop->iteration }}</td><td>{{ $s->name }}</td><td>{{ $s->academicYear->name ?? '-' }}</td>
                <td>{{ $s->start_date->format('M d, Y') }}</td><td>{{ $s->end_date->format('M d, Y') }}</td>
                <td>@if($s->is_current)<span class="badge bg-success">Current</span>@else - @endif</td>
                <td><a href="{{ route('admin.semesters.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('admin.semesters.destroy', $s) }}" class="d-inline">@csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div></div>
@endsection
