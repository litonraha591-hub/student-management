<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8"><title>Marksheet - {{ $student->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>@media print { .no-print { display: none; } }</style>
</head><body>
<div class="container mt-4">
    <div class="text-center mb-4 border-bottom pb-3">
        <h3>Student Management System</h3>
        <h5 class="text-primary">Mark Sheet</h5>
    </div>
    <div class="row mb-3">
        <div class="col-6"><strong>Name:</strong> {{ $student->user->name }}<br><strong>Student ID:</strong> {{ $student->student_id }}<br><strong>Class:</strong> {{ $student->class?->name }} - {{ $student->section?->name }}</div>
        <div class="col-6 text-end"><strong>Exam:</strong> {{ $exam->name ?? '-' }}<br><strong>Date:</strong> {{ now()->format('M d, Y') }}<br><strong>GPA:</strong> {{ $gpa ? number_format($gpa, 2) : '-' }}</div>
    </div>
    <table class="table table-bordered">
        <thead class="table-dark text-white"><tr><th>#</th><th>Subject</th><th>Quiz</th><th>Assignment</th><th>Mid</th><th>Final</th><th>Total</th><th>GPA</th><th>Grade</th></tr></thead>
        <tbody>@foreach($marks as $i => $m)<tr><td>{{ $i + 1 }}</td><td>{{ $m->subject->name }}</td><td>{{ $m->quiz_marks }}</td><td>{{ $m->assignment_marks }}</td><td>{{ $m->mid_marks }}</td><td>{{ $m->final_marks }}</td><td><strong>{{ $m->total_marks }}</strong></td><td>{{ $m->gpa ?? '-' }}</td><td><strong>{{ $m->grade ?? '-' }}</strong></td></tr>@endforeach</tbody>
    </table>
    <div class="text-center mt-4"><small class="text-muted">This is a computer-generated marksheet.</small></div>
    <div class="text-center mt-3 no-print"><button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print me-2"></i>Print Marksheet</button></div>
</div>
</body></html>
