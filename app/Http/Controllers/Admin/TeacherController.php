<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $teachers = $query->latest()->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $userId = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'phone' => $validated['phone'] ?? null,
            'photo' => isset($validated['photo']) ? $validated['photo']->store('photos', 'public') : null,
        ])->id;

        $employeeId = 'EMP' . str_pad(Teacher::max('id') + 1, 5, '0', STR_PAD_LEFT);

        Teacher::create([
            'user_id' => $userId,
            'employee_id' => $employeeId,
            'designation' => $validated['designation'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
            'joining_date' => $validated['joining_date'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('user');
        $classes = ClassModel::all();
        $sections = Section::all();
        $subjects = Subject::where('teacher_id', $teacher->user_id)->with('class')->get();
        return view('admin.teachers.show', compact('teacher', 'classes', 'sections', 'subjects'));
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = $teacher->user->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $teacher->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'photo' => $photoPath,
        ]);

        $teacher->update([
            'designation' => $validated['designation'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
            'joining_date' => $validated['joining_date'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
