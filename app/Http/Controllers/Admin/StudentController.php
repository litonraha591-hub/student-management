<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('user', 'class', 'section');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                  ->orWhere('roll', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(15);
        $classes = ClassModel::all();
        $sections = Section::all();

        return view('admin.students.index', compact('students', 'classes', 'sections'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $academicYears = AcademicYear::where('is_current', true)->get();
        return view('admin.students.create', compact('classes', 'sections', 'academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'date_of_birth' => 'nullable|date',
            'religion' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'admission_date' => 'required|date',
            'class_id' => 'nullable|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'roll' => 'nullable|string|max:20',
            'registration_number' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
        ]);

        $userId = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'phone' => $validated['phone'] ?? null,
            'photo' => isset($validated['photo']) ? $validated['photo']->store('photos', 'public') : null,
        ])->id;

        $studentId = 'STU' . str_pad(Student::max('id') + 1, 5, '0', STR_PAD_LEFT);

        Student::create([
            'user_id' => $userId,
            'student_id' => $studentId,
            'roll' => $validated['roll'] ?? null,
            'registration_number' => $validated['registration_number'] ?? null,
            'gender' => $validated['gender'],
            'blood_group' => $validated['blood_group'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'father_name' => $validated['father_name'] ?? null,
            'mother_name' => $validated['mother_name'] ?? null,
            'guardian_name' => $validated['guardian_name'] ?? null,
            'guardian_phone' => $validated['guardian_phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'admission_date' => $validated['admission_date'],
            'class_id' => $validated['class_id'] ?? null,
            'section_id' => $validated['section_id'] ?? null,
            'academic_year_id' => $validated['academic_year_id'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $student->load('user', 'class', 'section', 'academicYear', 'attendances', 'marks.exam', 'marks.subject');
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load('user');
        $classes = ClassModel::all();
        $sections = Section::all();
        $academicYears = AcademicYear::all();
        return view('admin.students.edit', compact('student', 'classes', 'sections', 'academicYears'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'date_of_birth' => 'nullable|date',
            'religion' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'class_id' => 'nullable|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'roll' => 'nullable|string|max:20',
            'registration_number' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,graduated,expelled',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = $student->user->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'photo' => $photoPath,
        ]);

        $student->update([
            'roll' => $validated['roll'] ?? null,
            'registration_number' => $validated['registration_number'] ?? null,
            'gender' => $validated['gender'],
            'blood_group' => $validated['blood_group'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'father_name' => $validated['father_name'] ?? null,
            'mother_name' => $validated['mother_name'] ?? null,
            'guardian_name' => $validated['guardian_name'] ?? null,
            'guardian_phone' => $validated['guardian_phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'class_id' => $validated['class_id'] ?? null,
            'section_id' => $validated['section_id'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
