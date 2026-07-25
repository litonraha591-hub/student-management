@extends('layouts.app')
@section('title', 'My Assignments')
@section('page-title', 'Assignments')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Title</th><th>Subject</th><th>Deadline</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>@foreach($assignments as $a)
        @php $submitted = $a->submissions->where('student_id', Auth::user()->student?->id)->first(); @endphp
        <tr><td>{{ $loop->iteration }}</td><td>{{ $a->title }}</td><td>{{ $a->subject->name ?? '-' }}</td><td>{{ $a->deadline->format('M d, Y') }}</td>
            <td>@if($submitted)<span class="badge bg-success">Submitted</span>@else<span class="badge bg-warning">Pending</span>@endif</td>
            <td><a href="{{ route('student.assignments.show', $a) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>View</a></td>
        </tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
