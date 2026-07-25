@extends('layouts.app')
@section('title', 'Exam Plans')
@section('page-title', 'Exam Plans')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Manage your exam schedules — Mid Term, Final Term, Quizzes & Assignments</p>
    </div>
    <a href="{{ route('teacher.exams.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Create Exam</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h3 class="text-primary mb-0">{{ $exams->total() }}</h3>
            <small class="text-muted">Total Exams</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h3 class="text-success mb-0">{{ $exams->where('type', 'mid')->count() }}</h3>
            <small class="text-muted">Mid Term</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h3 class="text-warning mb-0">{{ $exams->where('type', 'final')->count() }}</h3>
            <small class="text-muted">Final Term</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
            <h3 class="text-info mb-0">{{ $exams->where('type', 'quiz')->count() + $exams->where('type', 'assignment')->count() }}</h3>
            <small class="text-muted">Quiz / Assignment</small>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background:#f0f4ff;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Exam Name</th>
                        <th>Type</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $i => $exam)
                    <tr>
                        <td class="ps-4">{{ $exams->firstItem() + $i }}</td>
                        <td><strong>{{ $exam->name }}</strong></td>
                        <td>
                            @if($exam->type == 'mid')
                                <span class="badge bg-success">Mid Term</span>
                            @elseif($exam->type == 'final')
                                <span class="badge bg-warning text-dark">Final Term</span>
                            @elseif($exam->type == 'quiz')
                                <span class="badge bg-info">Quiz</span>
                            @else
                                <span class="badge bg-secondary">Assignment</span>
                            @endif
                        </td>
                        <td>{{ $exam->academicYear->name ?? '-' }}</td>
                        <td>{{ $exam->start_date->format('M d, Y') }}</td>
                        <td>{{ $exam->end_date->format('M d, Y') }}</td>
                        <td>
                            @if(now()->between($exam->start_date, $exam->end_date))
                                <span class="badge bg-primary">Ongoing</span>
                            @elseif(now()->gt($exam->end_date))
                                <span class="badge bg-secondary">Completed</span>
                            @else
                                <span class="badge bg-light text-dark">Upcoming</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('teacher.exams.show', $exam) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                            No exams created yet. Click "Create Exam" to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $exams->links() }}
    </div>
</div>
@endsection
