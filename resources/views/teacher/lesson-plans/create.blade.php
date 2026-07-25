@extends('layouts.app')
@section('title', 'Create Lesson Plan')
@section('page-title', 'Create Lesson Plan')
@section('content')
<div class="card shadow-sm border-0" style="border-radius:12px;">
    <div class="card-body">
        <form method="POST" action="{{ route('teacher.lesson-plans.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Subject</label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Class</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Shift</label>
                    <select name="section_id" class="form-select" required>
                        <option value="">-- Select Shift --</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Topic Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="e.g. Quadratic Equations - Chapter 3">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date</label>
                    <input type="date" name="plan_date" class="form-control" value="{{ old('plan_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Exam Type</label>
                    <select name="type" class="form-select" required>
                        <option value="mid" {{ old('type') == 'mid' ? 'selected' : '' }}>Mid Term</option>
                        <option value="final" {{ old('type') == 'final' ? 'selected' : '' }}>Final Term</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Academic Year</label>
                    <input type="text" name="academic_year" class="form-control" value="{{ old('academic_year', '2024-2025') }}" placeholder="e.g. 2024-2025">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description / Notes</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter topic details, learning objectives, homework...">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Lesson Plan</button>
                <a href="{{ route('teacher.lesson-plans.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
