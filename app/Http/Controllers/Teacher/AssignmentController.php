<?php

namespace App\Http\Controllers\Teacher;

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
        $assignments = Assignment::where('teacher_id', Auth::id())
            ->with('subject', 'class', 'section')
            ->latest()
            ->get();

        return view('teacher.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $user = Auth::user();
        $subjects = Subject::where('teacher_id', $user->id)->with('class')->get();
        $classes = ClassModel::whereIn('id', $subjects->pluck('class_id'))->get();
        $sections = Section::whereIn('class_id', $classes->pluck('id'))->get();

        return view('teacher.assignments.create', compact('subjects', 'classes', 'sections'));
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

        return redirect()->route('teacher.assignments.index')->with('success', 'Assignment created.');
    }

    public function show(Assignment $assignment)
    {
        abort_unless($assignment->teacher_id === Auth::id(), 403);

        $submissions = AssignmentSubmission::with('student.user')
            ->where('assignment_id', $assignment->id)
            ->get();

        return view('teacher.assignments.show', compact('assignment', 'submissions'));
    }

    public function destroy(Assignment $assignment)
    {
        abort_unless($assignment->teacher_id === Auth::id(), 403);

        $assignment->delete();
        return redirect()->route('teacher.assignments.index')->with('success', 'Assignment deleted.');
    }
}
