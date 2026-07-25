<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassRoutine;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoutine::with('class', 'section', 'subject', 'teacher');

        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        if ($request->filled('section_id')) $query->where('section_id', $request->section_id);
        if ($request->filled('day')) $query->where('day', $request->day);

        $routines = $query->orderBy('day')->orderBy('start_time')->get();
        $classes = ClassModel::all();
        $sections = Section::all();

        return view('admin.routines.index', compact('routines', 'classes', 'sections'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $subjects = Subject::all();
        return view('admin.routines.create', compact('classes', 'sections', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day' => 'required|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room' => 'nullable|string|max:50',
        ]);

        ClassRoutine::create($validated);
        return redirect()->route('admin.routines.index')->with('success', 'Routine entry added.');
    }

    public function destroy(ClassRoutine $routine)
    {
        $routine->delete();
        return back()->with('success', 'Routine entry removed.');
    }
}
