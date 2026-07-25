@extends('layouts.app')
@section('title', 'Attendance')
@section('page-title', 'Attendance Management')
@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white"><h6 class="mb-0">Mark Attendance</h6></div>
    <div class="card-body">
        <form method="GET" action="{{ route('teacher.attendance.mark') }}" id="attendance-filter-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-2"><label class="form-label" for="attendance-class">Class</label><select name="class_id" id="attendance-class" class="form-select" required><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
                <div class="col-md-2"><label class="form-label" for="attendance-section">Section</label><select name="section_id" id="attendance-section" class="form-select" required><option value="">Select</option>@foreach($sections as $s)<option value="{{ $s->id }}" data-class-id="{{ $s->class_id }}" {{ request('section_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
                <div class="col-md-2"><label class="form-label" for="attendance-subject">Subject</label><select name="subject_id" id="attendance-subject" class="form-select" required><option value="">Select</option>@foreach($subjects as $s)<option value="{{ $s->id }}" data-class-id="{{ $s->class_id }}" {{ request('subject_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
                <div class="col-md-2"><label class="form-label" for="attendance-date">Date</label><input type="date" name="date" id="attendance-date" class="form-control" value="{{ request('date', date('Y-m-d')) }}" required></div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Load</button></div>
            </div>
        </form>
    </div>
</div>

@if($attendances->count() > 0)
<div class="card shadow-sm border-0"><div class="card-body">
    <h6>Attendance Records</h6>
    <table class="table table-hover">
        <thead class="table-light"><tr><th>Student</th><th>Date</th><th>Status</th></tr></thead>
        <tbody>@foreach($attendances as $a)<tr><td>{{ $a->student->user->name }}</td><td>{{ $a->date->format('M d, Y') }}</td>
            <td><span class="badge bg-{{ $a->status == 'present' ? 'success' : ($a->status == 'absent' ? 'danger' : ($a->status == 'late' ? 'warning' : 'info')) }}">{{ ucfirst($a->status) }}</span></td></tr>@endforeach</tbody>
    </table>
</div></div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const classSelect = document.getElementById('attendance-class');
        const dependentSelects = [
            document.getElementById('attendance-section'),
            document.getElementById('attendance-subject')
        ];

        function filterOptions() {
            dependentSelects.forEach(function (select) {
                const selectedOption = select.options[select.selectedIndex];
                const selectedValue = selectedOption ? selectedOption.value : '';
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
