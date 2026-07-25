@extends('layouts.app')
@section('title', 'Teacher Report')
@section('page-title', 'Teacher Report')
@section('content')
<div class="card shadow-sm border-0"><div class="card-body">
    <table class="table table-hover" id="dataTable">
        <thead class="table-light"><tr><th>#</th><th>Employee ID</th><th>Name</th><th>Designation</th><th>Qualification</th><th>Joining Date</th></tr></thead>
        <tbody>@foreach($teachers as $t)<tr><td>{{ $loop->iteration }}</td><td>{{ $t->employee_id }}</td><td>{{ $t->user->name }}</td><td>{{ $t->designation ?? '-' }}</td><td>{{ $t->qualification ?? '-' }}</td><td>{{ $t->joining_date?->format('M d, Y') ?? '-' }}</td></tr>@endforeach</tbody>
    </table>
</div></div>
@endsection
