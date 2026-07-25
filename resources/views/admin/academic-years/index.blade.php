@extends('layouts.app')
@section('title', 'Academic Years')
@section('page-title', 'Academic Years')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.academic-years.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Academic Year</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover" id="dataTable">
            <thead class="table-light">
                <tr><th>#</th><th>Name</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($academicYears as $year)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $year->name }}</td>
                    <td>{{ $year->start_date->format('M d, Y') }}</td>
                    <td>{{ $year->end_date->format('M d, Y') }}</td>
                    <td>
                        @if($year->is_current)
                            <span class="badge bg-success">Current</span>
                        @else
                            <form method="POST" action="{{ route('admin.academic-years.set-current', $year) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="badge bg-secondary border-0">Set Current</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.academic-years.edit', $year) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.academic-years.destroy', $year) }}" class="d-inline">
                            @csrf @method('DELETE')
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
