@extends('layouts.app')
@section('title', 'Class Routine')
@section('page-title', 'Class Routine')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form method="GET" class="d-flex gap-2">
        <select name="class_id" class="form-select" style="width:150px"><option value="">All Classes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select>
        <select name="section_id" class="form-select" style="width:150px"><option value="">All Shifts</option>@foreach($sections as $s)<option value="{{ $s->id }}" {{ request('section_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select>
        <select name="day" class="form-select" style="width:150px"><option value="">All Days</option>@foreach(['saturday','sunday','monday','tuesday','wednesday','thursday','friday'] as $d)<option value="{{ $d }}" {{ request('day') == $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>@endforeach</select>
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.routines.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Entry</a>
</div>
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>Day</th><th>Time</th><th>Subject</th><th>Class</th><th>Shift</th><th>Teacher</th><th>Room</th><th>Action</th></tr></thead>
        <tbody>@foreach($routines as $r)<tr>
            <td><span class="badge bg-primary">{{ ucfirst($r->day) }}</span></td>
            <td>{{ $r->start_time }} - {{ $r->end_time }}</td>
            <td>{{ $r->subject->name ?? '-' }}</td><td>{{ $r->class->name ?? '-' }}</td><td>{{ $r->section->name ?? '-' }}</td><td>{{ $r->teacher->name ?? '-' }}</td><td>{{ $r->room ?? '-' }}</td>
            <td><form method="POST" action="{{ route('admin.routines.destroy', $r) }}" class="d-inline">@csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
            </form></td>
        </tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
