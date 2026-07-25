@extends('layouts.app')
@section('title', 'Assignment Details')
@section('page-title', $assignment->title)
@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Assignment Details</h6></div><div class="card-body">
            <p><strong>Subject:</strong> {{ $assignment->subject->name }}</p>
            <p><strong>Class:</strong> {{ $assignment->class->name }} - {{ $assignment->section->name }}</p>
            <p><strong>Deadline:</strong> {{ $assignment->deadline->format('M d, Y') }}</p>
            <p><strong>Description:</strong> {{ $assignment->description ?? '-' }}</p>
            @if($assignment->attachment)<p><a href="{{ asset('storage/'.$assignment->attachment) }}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fas fa-download me-1"></i>Download Attachment</a></p>@endif
        </div></div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Submissions ({{ $submissions->count() }})</h6></div><div class="card-body">
            @forelse($submissions as $sub)
            <div class="border-bottom py-2">
                <strong>{{ $sub->student->user->name }}</strong> - <span class="badge bg-{{ $sub->status == 'submitted' ? 'info' : ($sub->status == 'reviewed' ? 'success' : 'warning') }}">{{ ucfirst($sub->status) }}</span>
                @if($sub->file_path)<a href="{{ asset('storage/'.$sub->file_path) }}" class="ms-2" target="_blank"><i class="fas fa-file-download"></i></a>@endif
            </div>
            @empty <p class="text-muted text-center py-3">No submissions yet</p>
            @endforelse
        </div></div>
    </div>
</div>
@endsection
