@extends('layouts.app')
@section('title', 'Mark Attendance')
@section('page-title', 'Mark Attendance')
@section('content')

<div class="card shadow-sm border-0" style="border-radius:12px;">
    <div class="card-body">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('teacher.attendance.mark') }}" class="row g-3 mb-4" id="attendance-filter-form">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Class</label>
                <select name="class_id" class="form-select" required>
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Shift</label>
                <select name="section_id" class="form-select" required>
                    <option value="">-- Select Shift --</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" data-class-id="{{ $section->class_id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Subject</label>
                <select name="subject_id" class="form-select" required>
                    <option value="">-- Select Subject --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" data-class-id="{{ $subject->class_id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date', date('Y-m-d')) }}" onchange="this.form.submit()">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Load</button>
            </div>
        </form>

        {{-- Student Table --}}
        @if(request()->filled(['class_id', 'section_id', 'subject_id']))
            @if($students->count() > 0)
            <form method="POST" action="{{ route('teacher.attendance.store') }}">@csrf
                <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                <input type="hidden" name="date" value="{{ request('date', date('Y-m-d')) }}">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background:#f0f4ff;">
                            <tr>
                                <th class="ps-4" style="width:60px;">#</th>
                                <th>Student Name</th>
                                <th>Roll</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $i => $item)
                            <tr>
                                <td class="ps-4">{{ $i + 1 }}</td>
                                <td>
                                    <input type="hidden" name="attendance[{{ $i }}][student_id]" value="{{ $item['student']->id }}">
                                    <strong>{{ $item['student']->user->name }}</strong>
                                </td>
                                <td>{{ $item['student']->roll ?? '-' }}</td>
                                <td>
                                    <select name="attendance[{{ $i }}][status]" class="form-select form-select-sm" required style="width:160px;">
                                        <option value="present" {{ ($item['attendance']->status ?? '') == 'present' ? 'selected' : '' }}>Present</option>
                                        <option value="absent" {{ ($item['attendance']->status ?? '') == 'absent' ? 'selected' : '' }}>Absent</option>
                                        <option value="late" {{ ($item['attendance']->status ?? '') == 'late' ? 'selected' : '' }}>Late</option>
                                        <option value="leave" {{ ($item['attendance']->status ?? '') == 'leave' ? 'selected' : '' }}>Leave</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary btn-lg mt-3">
                    <i class="fas fa-save me-2"></i>Save Attendance
                </button>
            </form>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <p>No students found in this class/shift.</p>
                </div>
            @endif
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-hand-pointer fa-3x mb-3"></i>
                <h5>Select Class, Shift & Subject above to mark attendance</h5>
            </div>
        @endif
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('attendance-filter-form');
        const classSelect = form.querySelector('select[name="class_id"]');
        const dependentSelects = [
            form.querySelector('select[name="section_id"]'),
            form.querySelector('select[name="subject_id"]')
        ];

        function filterOptions() {
            dependentSelects.forEach(function (select) {
                const selectedValue = select.value;
                let selectedStillAvailable = false;

                Array.from(select.options).forEach(function (option) {
                    if (!option.value) return;
                    const available = option.dataset.classId === classSelect.value;
                    option.hidden = !available;
                    option.disabled = !available;
                    if (available && option.value === selectedValue) selectedStillAvailable = true;
                });

                if (!selectedStillAvailable) select.value = '';
            });
        }

        classSelect.addEventListener('change', filterOptions);
        filterOptions();
    });
</script>
@endsection
