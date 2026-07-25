<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\GradeSystem;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $subjectIds = Subject::where('teacher_id', $user->id)->pluck('id');

        $query = Mark::whereIn('subject_id', $subjectIds)
            ->with('student.user', 'subject', 'exam', 'class', 'section');

        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        if ($request->filled('section_id')) $query->where('section_id', $request->section_id);
        if ($request->filled('exam_id')) $query->where('exam_id', $request->exam_id);

        $marks = $query->latest()->paginate(20);

        $subjects = Subject::where('teacher_id', $user->id)->pluck('id');
        $classes = ClassModel::whereIn('id', Subject::where('teacher_id', $user->id)->pluck('class_id'))->get();
        $sections = Section::whereIn('class_id', $classes->pluck('id'))->get();
        $exams = Exam::all();

        return view('teacher.results.index', compact('marks', 'exams', 'classes', 'sections'));
    }

    public function enterMarks(Request $request)
    {
        $user = Auth::user();
        $subjects = Subject::where('teacher_id', $user->id)->with('class')->get();
        $classes = ClassModel::whereIn('id', $subjects->pluck('class_id'))->get();
        $sections = Section::whereIn('class_id', $classes->pluck('id'))->get();
        $exams = Exam::all();
        $students = collect();

        if ($request->filled(['exam_id', 'class_id', 'section_id', 'subject_id'])) {
            $students = Student::where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->with('user')
                ->get()
                ->map(function ($student) use ($request) {
                    $existingMark = Mark::where('student_id', $student->id)
                        ->where('subject_id', $request->subject_id)
                        ->where('exam_id', $request->exam_id)
                        ->first();
                    return ['student' => $student, 'mark' => $existingMark];
                });
        }

        return view('teacher.results.enter-marks', compact('subjects', 'classes', 'sections', 'exams', 'students'));
    }

    public function saveMarks(Request $request)
    {
        $teacherSubjectIds = Subject::where('teacher_id', Auth::id())->pluck('id');
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => ['required', 'exists:subjects,id', function ($attribute, $value, $fail) use ($teacherSubjectIds) {
                if (!$teacherSubjectIds->contains((int) $value)) $fail('You can only save marks for your subjects.');
            }],
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

        return redirect()->route('teacher.results.index')->with('success', 'Marks saved successfully.');
    }
}
