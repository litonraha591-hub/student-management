<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Semester;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('academicYear', 'semester')->latest()->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $academicYears = AcademicYear::all();
        $semesters = Semester::all();
        return view('admin.exams.create', compact('academicYears', 'semesters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:quiz,assignment,mid,final,practical',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Exam::create($validated);
        return redirect()->route('admin.exams.index')->with('success', 'Exam created successfully.');
    }

    public function edit(Exam $exam)
    {
        $academicYears = AcademicYear::all();
        $semesters = Semester::all();
        return view('admin.exams.edit', compact('exam', 'academicYears', 'semesters'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:quiz,assignment,mid,final,practical',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $exam->update($validated);
        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted successfully.');
    }

    public function schedule(Exam $exam)
    {
        $schedules = $exam->schedules()->with('subject', 'class')->get();
        $subjects = Subject::all();
        $classes = ClassModel::all();
        return view('admin.exams.schedule', compact('exam', 'schedules', 'subjects', 'classes'));
    }

    public function storeSchedule(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'hall' => 'nullable|string|max:50',
        ]);

        $exam->schedules()->create($validated);
        return back()->with('success', 'Exam schedule added.');
    }

    public function destroySchedule(ExamSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule removed.');
    }
}
