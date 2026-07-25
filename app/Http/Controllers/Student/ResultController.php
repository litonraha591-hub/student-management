<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $student = Auth::user()?->student;
        
        if (!$student || !$student->id) {
            return view('student.results.index', [
                'student' => $student,
                'marks' => collect(),
                'exams' => collect(),
                'gpa' => 0,
                'totalStudents' => 0,
            ]);
        }

        $marks = Mark::where('student_id', $student->id)
            ->with('subject', 'exam')
            ->latest()
            ->get();

        $exams = $marks->groupBy('exam_id');
        $gpa = $marks->where('gpa', '!=', null)->avg('gpa');
        $gpa = $gpa ? round($gpa, 2) : 0;

        $totalStudents = \App\Models\Student::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->count();

        return view('student.results.index', compact('student', 'marks', 'exams', 'gpa', 'totalStudents'));
    }

    public function marksheet($examId)
    {
        $student = Auth::user()->student;
        $marks = Mark::where('student_id', $student->id)
            ->where('exam_id', $examId)
            ->with('subject', 'exam')
            ->get();

        $exam = $marks->first()?->exam;
        $gpa = $marks->where('gpa', '!=', null)->avg('gpa');

        return view('student.results.marksheet', compact('student', 'marks', 'exam', 'gpa'));
    }
}
