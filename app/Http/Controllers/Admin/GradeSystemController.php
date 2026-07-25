<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeSystem;
use Illuminate\Http\Request;

class GradeSystemController extends Controller
{
    public function index()
    {
        $grades = GradeSystem::orderBy('min_marks', 'desc')->get();
        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        return view('admin.grades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grade_name' => 'required|string|max:10',
            'min_marks' => 'required|numeric|min:0|max:100',
            'max_marks' => 'required|numeric|min:0|max:100|gte:min_marks',
            'gpa' => 'required|numeric|min:0|max:4',
        ]);

        GradeSystem::create($validated);
        return redirect()->route('admin.grades.index')->with('success', 'Grade rule added.');
    }

    public function edit(GradeSystem $grade)
    {
        return view('admin.grades.edit', compact('grade'));
    }

    public function update(Request $request, GradeSystem $grade)
    {
        $validated = $request->validate([
            'grade_name' => 'required|string|max:10',
            'min_marks' => 'required|numeric|min:0|max:100',
            'max_marks' => 'required|numeric|min:0|max:100|gte:min_marks',
            'gpa' => 'required|numeric|min:0|max:4',
        ]);

        $grade->update($validated);
        return redirect()->route('admin.grades.index')->with('success', 'Grade rule updated.');
    }

    public function destroy(GradeSystem $grade)
    {
        $grade->delete();
        return redirect()->route('admin.grades.index')->with('success', 'Grade rule deleted.');
    }
}
