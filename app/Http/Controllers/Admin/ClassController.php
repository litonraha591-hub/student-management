<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Department;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::with('department', 'sections', 'subjects')->latest()->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.classes.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        ClassModel::create($validated);
        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    public function edit(ClassModel $class)
    {
        $departments = Department::all();
        return view('admin.classes.edit', compact('class', 'departments'));
    }

    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $class->update($validated);
        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassModel $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
}
