<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassRoutine;
use App\Models\Mark;
use App\Models\Notice;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return view('student.dashboard.index', [
                'student' => null,
                'attendancePercentage' => 0,
                'todayClasses' => collect(),
                'subjects' => collect(),
                'recentMarks' => collect(),
                'recentNotices' => Notice::latest()->take(5)->get(),
            ]);
        }

        $today = strtolower(now()->englishDayOfWeek);

        $todayClasses = ClassRoutine::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->where('day', $today)
            ->with('subject', 'teacher')
            ->orderBy('start_time')
            ->get();

        $totalAttendance = $student->attendances->count();
        $presentCount = $student->attendances->where('status', 'present')->count();
        $attendancePercentage = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;

        $recentMarks = $student->marks()->with('subject', 'exam')->latest()->take(5)->get();
        $recentNotices = Notice::latest()->take(5)->get();

        $subjects = \App\Models\Subject::where('class_id', $student->class_id)->with('teacher')->get();

        $allMarks = $student->marks()->whereNotNull('gpa')->get();
        $gpa = $allMarks->count() > 0 ? round($allMarks->avg('gpa'), 2) : 0;

        return view('student.dashboard.index', compact(
            'student', 'attendancePercentage', 'todayClasses',
            'subjects', 'recentMarks', 'recentNotices', 'gpa'
        ));
    }
}
