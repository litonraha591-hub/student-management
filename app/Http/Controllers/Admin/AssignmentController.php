<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with('subject', 'class', 'section', 'teacher')->latest()->get();
        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $subjects = Subject::all();
        return view('admin.assignments.create', compact('classes', 'sections', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'deadline' => 'required|date|after:today',
            'attachment' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('assignments', 'public');
        }

        $validated['teacher_id'] = Auth::id();
        Assignment::create($validated);

        return redirect()->route('admin.assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function show(Assignment $assignment)
    {
        $submissions = AssignmentSubmission::with('student.user')->where('assignment_id', $assignment->id)->get();
        return view('admin.assignments.show', compact('assignment', 'submissions'));
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('admin.assignments.index')->with('success', 'Assignment deleted.');
    }
}
