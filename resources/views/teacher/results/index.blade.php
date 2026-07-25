@extends('layouts.app')
@section('title', 'Results')
@section('page-title', 'Results')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('teacher.results.enter') }}" class="btn btn-primary"><i class="fas fa-pen me-2"></i>Enter Marks</a>
</div>

{{-- Filters --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius:12px;">
    <div class="card-body">
        <form method="GET" action="{{ route('teacher.results.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Class</label>
                <select name="class_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Shift</label>
                <select name="section_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Shifts</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Exam</label>
                <select name="exam_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Exams</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

{{-- Results Table --}}
<div class="card shadow-sm border-0" style="border-radius:12px;">
    <div class="card-body">
        @if($marks->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background:#f0f4ff;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Shift</th>
                        <th>Subject</th>
                        <th>Exam</th>
                        <th>Type</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">GPA</th>
                        <th class="text-center">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marks as $m)
                    <tr>
                        <td class="ps-4">{{ $marks->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $m->student->user->name ?? '-' }}</strong></td>
                        <td>{{ $m->class->name ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $m->section->name ?? '-' }}</span></td>
                        <td>{{ $m->subject->name ?? '-' }}</td>
                        <td>{{ $m->exam->name ?? '-' }}</td>
                        <td>
                            @if($m->exam->type == 'mid')
                                <span class="badge bg-warning text-dark">Mid Term</span>
                            @elseif($m->exam->type == 'final')
                                <span class="badge bg-success">Final Term</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($m->exam->type) }}</span>
                            @endif
                        </td>
                        <td class="text-center fw-bold">{{ $m->total_marks }}</td>
                        <td class="text-center">{{ $m->gpa ?? '-' }}</td>
                        <td class="text-center">
                            @if($m->grade)
                                <span class="badge bg-primary">{{ $m->grade }}</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $marks->withQueryString()->links() }}
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-chart-bar fa-3x mb-3"></i>
                <h5>No results found</h5>
                <p>Select a class, shift, or exam to filter results, or enter marks first.</p>
                <a href="{{ route('teacher.results.enter') }}" class="btn btn-primary mt-2"><i class="fas fa-pen me-2"></i>Enter Marks Now</a>
            </div>
        @endif
    </div>
</div>
@endsection
