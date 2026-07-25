@extends('layouts.app')
@section('title', 'Attendance History')
@section('page-title', 'Attendance History')
@section('content')
<div class="card shadow-sm border-0" style="border-radius:12px;">
    <div class="card-body">
        @if($attendances->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead style="background:#f0f4ff;">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Shift</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Marked By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $a)
                    <tr>
                        <td class="ps-4">{{ $attendances->firstItem() + $loop->index }}</td>
                        <td>{{ $a->date->format('M d, Y') }}</td>
                        <td><strong>{{ $a->student->user->name ?? '-' }}</strong></td>
                        <td>{{ $a->class->name ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $a->section->name ?? '-' }}</span></td>
                        <td>{{ $a->subject->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $a->status == 'present' ? 'success' : ($a->status == 'absent' ? 'danger' : ($a->status == 'late' ? 'warning' : 'info')) }}">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td><small class="text-muted">{{ $a->marked_by ? ($a->markedBy->name ?? 'Unknown') : '-' }}</small></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary edit-attendance-btn"
                                    data-id="{{ $a->id }}"
                                    data-status="{{ $a->status }}"
                                    data-date="{{ $a->date->format('Y-m-d') }}"
                                    data-student="{{ $a->student->user->name ?? '' }}"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $attendances->withQueryString()->links() }}
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-check-double fa-3x mb-3"></i>
                <h5>No attendance records found</h5>
            </div>
        @endif
    </div>
</div>

<!-- Edit Attendance Modal -->
<div class="modal fade" id="editAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px;">
            <form method="POST" action="{{ route('teacher.attendance.update-status') }}">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="attendance_id" id="edit_attendance_id">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Student</label>
                        <input type="text" class="form-control" id="edit_student_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="text" class="form-control" id="edit_date" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                            <option value="leave">Leave</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.edit-attendance-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_attendance_id').value = this.dataset.id;
        document.getElementById('edit_student_name').value = this.dataset.student;
        document.getElementById('edit_date').value = this.dataset.date;
        document.querySelector('#editAttendanceModal select[name="status"]').value = this.dataset.status;
        new bootstrap.Modal(document.getElementById('editAttendanceModal')).show();
    });
});
</script>
@endsection
