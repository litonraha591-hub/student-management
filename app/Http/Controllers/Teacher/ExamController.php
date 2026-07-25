<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('academicYear', 'semester')
            ->latest()
            ->paginate(15);

        return view('teacher.exams.index', compact('exams'));
    }

    public function create()
    {
        $academicYears = AcademicYear::all();
        return view('teacher.exams.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:mid,final,quiz,assignment',
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validated['created_by'] = Auth::id();

        Exam::create($validated);

        return redirect()->route('teacher.exams.index')->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load('academicYear', 'semester', 'schedules.subject', 'schedules.class');
        return view('teacher.exams.show', compact('exam'));
    }
}
