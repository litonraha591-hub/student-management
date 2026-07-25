@extends('layouts.app')
@section('title', 'Assignment')
@section('page-title', $assignment->title)
@section('content')
<div class="row g-4">
    <div class="col-md-6"><div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Details</h6></div><div class="card-body">
        <p><strong>Subject:</strong> {{ $assignment->subject->name }}</p>
        <p><strong>Class:</strong> {{ $assignment->class->name }} - {{ $assignment->section->name }}</p>
        <p><strong>Deadline:</strong> {{ $assignment->deadline->format('M d, Y') }}</p>
        <p><strong>Description:</strong> {{ $assignment->description ?? '-' }}</p>
    </div></div></div>
    <div class="col-md-6"><div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Submissions ({{ $submissions->count() }})</h6></div><div class="card-body">
        @forelse($submissions as $s)<div class="border-bottom py-2 d-flex justify-content-between align-items-center">
            <div><strong>{{ $s->student->user->name }}</strong> <span class="badge bg-info">{{ $s->status }}</span></div>
            @if($s->file_path)<a href="{{ asset('storage/'.$s->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-download"></i></a>@endif
        </div>@empty <p class="text-muted text-center py-3">No submissions yet</p>@endforelse
    </div></div></div>
</div>
@endsection
