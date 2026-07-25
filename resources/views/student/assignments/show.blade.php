@extends('layouts.app')
@section('title', 'Assignment')
@section('page-title', $assignment->title)
@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Assignment Details</h6></div><div class="card-body">
            <p><strong>Subject:</strong> {{ $assignment->subject->name }}</p>
            <p><strong>Deadline:</strong> {{ $assignment->deadline->format('M d, Y') }}</p>
            <p><strong>Description:</strong> {{ $assignment->description ?? 'No description' }}</p>
            @if($assignment->attachment)<p><a href="{{ asset('storage/'.$assignment->attachment) }}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fas fa-download me-1"></i>Download</a></p>@endif
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0"><div class="card-header bg-white"><h6 class="mb-0">Your Submission</h6></div><div class="card-body">
            @if($submission)
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>Submitted</div>
                <p><strong>Status:</strong> {{ ucfirst($submission->status) }}</p>
                @if($submission->file_path)<a href="{{ asset('storage/'.$submission->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fas fa-download me-1"></i>View File</a>@endif
                @if($submission->marks)<p class="mt-2"><strong>Marks:</strong> {{ $submission->marks }}</p>@endif
                @if($submission->feedback)<p><strong>Feedback:</strong> {{ $submission->feedback }}</p>@endif
            @else
                <form method="POST" action="{{ route('student.assignments.submit', $assignment) }}" enctype="multipart/form-data">@csrf
                    <div class="mb-3"><label class="form-label">Upload File (PDF/ZIP)</label><input type="file" name="file" class="form-control" required accept=".pdf,.zip,.rar"></div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-upload me-2"></i>Submit</button>
                </form>
            @endif
        </div></div>
    </div>
</div>
@endsection
