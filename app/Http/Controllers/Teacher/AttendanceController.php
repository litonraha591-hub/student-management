<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $subjects = Subject::where('teacher_id', $user->id)->with('class')->get();
        $classes = ClassModel::whereIn('id', $subjects->pluck('class_id'))->get();
        $sections = Section::whereIn('class_id', $classes->pluck('id'))
            ->when($request->filled('class_id'), fn ($query) => $query->where('class_id', $request->class_id))
            ->get();

        $attendances = collect();
        if ($request->filled(['class_id', 'section_id', 'subject_id', 'date'])) {
            $subjectIsAssignedToClass = $subjects->contains(
                fn ($subject) => $subject->id == $request->subject_id && $subject->class_id == $request->class_id
            );

            if ($subjectIsAssignedToClass) {
                $attendances = Attendance::where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->where('subject_id', $request->subject_id)
                    ->whereDate('date', $request->date)
                    ->with('student.user')
                    ->get();
            }
        }

        return view('teacher.attendance.index', compact('subjects', 'classes', 'sections', 'attendances'));
    }

    public function mark(Request $request)
    {
        $user = Auth::user();
        $subjects = Subject::where('teacher_id', $user->id)->with('class')->get();
        $classes = ClassModel::whereIn('id', $subjects->pluck('class_id'))->get();
        $sections = Section::whereIn('class_id', $classes->pluck('id'))
            ->when($request->filled('class_id'), fn ($query) => $query->where('class_id', $request->class_id))
            ->get();
        $students = collect();

        if ($request->filled(['class_id', 'section_id', 'subject_id'])) {
            $subjectIsAssignedToClass = $subjects->contains(
                fn ($subject) => $subject->id == $request->subject_id && $subject->class_id == $request->class_id
            );

            if ($subjectIsAssignedToClass) {
                $students = Student::where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->with('user')
                    ->get()
                    ->map(function ($student) use ($request) {
                        $existing = Attendance::where('student_id', $student->id)
                            ->where('subject_id', $request->subject_id)
                            ->whereDate('date', $request->date ?? now()->toDateString())
                            ->first();
                        return ['student' => $student, 'attendance' => $existing];
                    });
            }
        }

        return view('teacher.attendance.mark', compact('subjects', 'classes', 'sections', 'students'));
    }

    public function store(Request $request)
    {
        $teacherSubjectIds = Subject::where('teacher_id', Auth::id())->pluck('id');
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => ['required', 'exists:subjects,id', function ($attribute, $value, $fail) use ($teacherSubjectIds) {
                if (!$teacherSubjectIds->contains((int) $value)) $fail('You can only mark attendance for your subjects.');
            }],
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late,leave',
        ]);

        foreach ($validated['attendance'] as $att) {
            $studentBelongsToClass = Student::whereKey($att['student_id'])
                ->where('class_id', $validated['class_id'])
                ->where('section_id', $validated['section_id'])
                ->exists();
            if (!$studentBelongsToClass) {
                abort(422, 'The selected student does not belong to this class and section.');
            }

            Attendance::updateOrCreate(
                [
                    'student_id' => $att['student_id'],
                    'class_id' => $validated['class_id'],
                    'section_id' => $validated['section_id'],
                    'subject_id' => $validated['subject_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $att['status'],
                    'marked_by' => Auth::id(),
                ]
            );
        }

        return redirect()->route('teacher.attendance.index')->with('success', 'Attendance saved successfully.');
    }

    public function history(Request $request)
    {
        $query = Attendance::where('marked_by', Auth::id())->with('student.user', 'class', 'section', 'subject', 'markedBy');

        if ($request->filled('date')) $query->whereDate('date', $request->date);
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);

        $attendances = $query->latest('date')->paginate(20);
        return view('teacher.attendance.history', compact('attendances'));
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'status' => 'required|in:present,absent,late,leave',
        ]);

        $attendance = Attendance::where('id', $validated['attendance_id'])
            ->where('marked_by', Auth::id())
            ->firstOrFail();
        $attendance->update(['status' => $validated['status']]);

        return redirect()->route('teacher.attendance.history')->with('success', 'Attendance updated successfully.');
    }
}
