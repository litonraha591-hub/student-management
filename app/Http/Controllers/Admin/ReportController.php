<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\FeePayment;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function studentReport(Request $request)
    {
        $query = Student::with('user', 'class', 'section');
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        if ($request->filled('section_id')) $query->where('section_id', $request->section_id);

        $students = $query->get();
        $classes = ClassModel::all();

        return view('admin.reports.student', compact('students', 'classes'));
    }

    public function teacherReport()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.reports.teacher', compact('teachers'));
    }

    public function attendanceReport(Request $request)
    {
        $query = \App\Models\Attendance::with('student.user', 'class', 'section', 'subject');
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        if ($request->filled('month')) {
            $date = \Carbon\Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)->whereYear('date', $date->year);
        }

        $attendances = $query->get();
        $classes = ClassModel::all();

        $summary = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
        ];

        return view('admin.reports.attendance', compact('attendances', 'classes', 'summary'));
    }

    public function resultReport(Request $request)
    {
        $query = Mark::with('student.user', 'subject', 'exam');
        if ($request->filled('exam_id')) $query->where('exam_id', $request->exam_id);
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);

        $marks = $query->get();
        $exams = \App\Models\Exam::all();
        $classes = ClassModel::all();

        return view('admin.reports.result', compact('marks', 'exams', 'classes'));
    }

    public function feeReport(Request $request)
    {
        $query = FeePayment::with('student.user', 'fee');
        if ($request->filled('status')) $query->where('status', $request->status);

        $payments = $query->get();
        $summary = [
            'total' => $payments->sum('fee.amount'),
            'paid' => $payments->where('status', 'paid')->sum('amount_paid'),
            'pending' => $payments->where('status', 'pending')->sum('fee.amount'),
            'partial' => $payments->where('status', 'partial')->sum('amount_paid'),
        ];

        return view('admin.reports.fee', compact('payments', 'summary'));
    }
}
