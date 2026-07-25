<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('class', 'teacher')->latest()->get();
        $classes = ClassModel::all();
        return view('admin.sections.index', compact('sections', 'classes'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        return view('admin.sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Section::create($validated);
        return redirect()->route('admin.sections.index')->with('success', 'Shift created successfully.');
    }

    public function edit(Section $section)
    {
        $classes = ClassModel::all();
        return view('admin.sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $section->update($validated);
        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully.');
    }
}
