<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $student = Auth::user()?->student;
        
        if (!$student || !$student->class_id || !$student->section_id) {
            return view('student.assignments.index', [
                'assignments' => collect(),
            ]);
        }

        $assignments = Assignment::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->with('subject', 'teacher')
            ->latest()
            ->get();

        return view('student.assignments.index', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $student = Auth::user()->student;
        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->first();

        return view('student.assignments.show', compact('assignment', 'submission'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $student = Auth::user()->student;

        $validated = $request->validate([
            'file' => 'required|file|max:20480',
        ]);

        $filePath = $request->file('file')->store('submissions', 'public');

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => $student->id],
            [
                'file_path' => $filePath,
                'status' => 'submitted',
            ]
        );

        return back()->with('success', 'Assignment submitted successfully.');
    }
}
