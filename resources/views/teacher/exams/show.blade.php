@extends('layouts.app')
@section('title', $exam->name)
@section('page-title', $exam->name)
@section('content')

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Exam Title</div>
                        <h5 class="mb-0">{{ $exam->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Type</div>
                        <span class="badge bg-{{ $exam->type == 'mid' ? 'success' : ($exam->type == 'final' ? 'warning text-dark' : 'info') }} fs-6">
                            {{ ucfirst($exam->type) }} Term
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Academic Year</div>
                        <strong>{{ $exam->academicYear->name ?? '-' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Semester</div>
                        <strong>{{ $exam->semester->name ?? '-' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Start Date</div>
                        <strong>{{ $exam->start_date->format('M d, Y') }}</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">End Date</div>
                        <strong>{{ $exam->end_date->format('M d, Y') }}</strong>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small mb-1">Duration</div>
                        <strong>{{ $exam->start_date->diffInDays($exam->end_date) + 1 }} days</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body text-center p-4">
                @if(now()->between($exam->start_date, $exam->end_date))
                    <div class="mb-3"><span class="badge bg-primary fs-5 px-4 py-2">Ongoing</span></div>
                    <p class="text-muted">This exam is currently in progress.</p>
                @elseif(now()->gt($exam->end_date))
                    <div class="mb-3"><span class="badge bg-secondary fs-5 px-4 py-2">Completed</span></div>
                    <p class="text-muted">This exam has ended.</p>
                @else
                    <div class="mb-3"><span class="badge bg-light text-dark fs-5 px-4 py-2">Upcoming</span></div>
                    <p class="text-muted">Starts in {{ now()->diffInDays($exam->start_date) }} days.</p>
                @endif

                <a href="{{ route('teacher.exams.index') }}" class="btn btn-outline-primary mt-3"><i class="fas fa-arrow-left me-2"></i>Back to Exams</a>
            </div>
        </div>
    </div>
</div>
@endsection
