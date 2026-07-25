<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()?->student;
        
        if (!$student || !$student->id) {
            return view('student.attendance.index', [
                'attendances' => collect(),
                'totalDays' => 0,
                'presentDays' => 0,
                'absentDays' => 0,
                'lateDays' => 0,
                'leaveDays' => 0,
                'percentage' => 0,
            ]);
        }

        $query = Attendance::where('student_id', $student->id)
            ->with('subject', 'class', 'section');

        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)->whereYear('date', $date->year);
        }

        $attendances = $query->latest('date')->paginate(20);

        $totalDays = $attendances->total();
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $lateDays = $attendances->where('status', 'late')->count();
        $leaveDays = $attendances->where('status', 'leave')->count();

        $totalAll = Attendance::where('student_id', $student->id)->count();
        $presentAll = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $percentage = $totalAll > 0 ? round(($presentAll / $totalAll) * 100, 1) : 0;

        return view('student.attendance.index', compact(
            'attendances', 'totalDays', 'presentDays', 'absentDays',
            'lateDays', 'leaveDays', 'percentage'
        ));
    }
}
