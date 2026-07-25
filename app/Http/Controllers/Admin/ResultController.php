<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\GradeSystem;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Mark::with('student.user', 'subject', 'exam', 'class', 'section');

        if ($request->filled('exam_id')) $query->where('exam_id', $request->exam_id);
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        if ($request->filled('section_id')) $query->where('section_id', $request->section_id);
        if ($request->filled('subject_id')) $query->where('subject_id', $request->subject_id);

        $marks = $query->latest()->paginate(20);
        $exams = Exam::all();
        $classes = ClassModel::all();
        $sections = Section::all();
        $subjects = Subject::all();

        return view('admin.results.index', compact('marks', 'exams', 'classes', 'sections', 'subjects'));
    }

    public function enterMarks(Request $request)
    {
        $exams = Exam::all();
        $classes = ClassModel::all();
        $sections = Section::when($request->filled('class_id'), function ($query) use ($request) {
            $query->where('class_id', $request->class_id);
        })->get();
        $subjects = Subject::when($request->filled('class_id'), function ($query) use ($request) {
            $query->where('class_id', $request->class_id);
        })->get();
        $students = collect();

        if ($request->filled('exam_id') && $request->filled('class_id') && $request->filled('section_id') && $request->filled('subject_id')) {
            $sectionMatchesClass = Section::whereKey($request->section_id)
                ->where('class_id', $request->class_id)->exists();
            $subjectMatchesClass = Subject::whereKey($request->subject_id)
                ->where('class_id', $request->class_id)->exists();

            if ($sectionMatchesClass && $subjectMatchesClass) {
                $students = \App\Models\Student::where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->with('user')
                    ->get()
                    ->map(function ($student) use ($request) {
                        $existingMark = Mark::where('student_id', $student->id)
                            ->where('subject_id', $request->subject_id)
                            ->where('exam_id', $request->exam_id)
                            ->first();
                        return [
                            'student' => $student,
                            'mark' => $existingMark,
                        ];
                    });
            }
        }

        return view('admin.results.enter-marks', compact('exams', 'classes', 'sections', 'subjects', 'students'));
    }

    public function saveMarks(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'marks' => 'required|array',
            'marks.*.student_id' => 'required|exists:students,id',
            'marks.*.quiz_marks' => 'nullable|numeric|min:0',
            'marks.*.assignment_marks' => 'nullable|numeric|min:0',
            'marks.*.mid_marks' => 'nullable|numeric|min:0',
            'marks.*.final_marks' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['marks'] as $markData) {
            $total = ($markData['quiz_marks'] ?? 0) + ($markData['assignment_marks'] ?? 0)
                   + ($markData['mid_marks'] ?? 0) + ($markData['final_marks'] ?? 0);

            $gradeData = GradeSystem::calculateGrade($total);

            Mark::updateOrCreate(
                [
                    'student_id' => $markData['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'exam_id' => $validated['exam_id'],
                ],
                [
                    'class_id' => $validated['class_id'],
                    'section_id' => $validated['section_id'],
                    'quiz_marks' => $markData['quiz_marks'] ?? 0,
                    'assignment_marks' => $markData['assignment_marks'] ?? 0,
                    'mid_marks' => $markData['mid_marks'] ?? 0,
                    'final_marks' => $markData['final_marks'] ?? 0,
                    'total_marks' => $total,
                    'gpa' => $gradeData['gpa'] ?? null,
                    'grade' => $gradeData['grade'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.results.index')->with('success', 'Marks saved successfully.');
    }

    public function showStudentResult($studentId)
    {
        $student = \App\Models\Student::with('user', 'class', 'section')->findOrFail($studentId);
        $marks = Mark::where('student_id', $studentId)->with('subject', 'exam')->get();

        $totalGpa = $marks->where('gpa', '!=', null)->avg('gpa');

        return view('admin.results.show-student', compact('student', 'marks', 'totalGpa'));
    }
}
