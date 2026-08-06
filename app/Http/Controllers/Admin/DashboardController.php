<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Notice;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalStudents' => Student::count(),
            'totalTeachers' => Teacher::count(),
            'totalClasses' => ClassModel::count(),
            'totalSections' => Section::count(),
            'totalSubjects' => Subject::count(),
            'todayAttendance' => Attendance::whereDate('date', Carbon::today())->count(),
            'todayPresent' => Attendance::whereDate('date', Carbon::today())->where('status', 'present')->count(),
            'todayAbsent' => Attendance::whereDate('date', Carbon::today())->where('status', 'absent')->count(),
            'todayLate' => Attendance::whereDate('date', Carbon::today())->where('status', 'late')->count(),
            'recentNotices' => Notice::with('creator')->latest()->take(5)->get(),
            'monthlyAttendance' => $this->getMonthlyAttendance(),
            'currentYear' => AcademicYear::where('is_current', true)->first(),
        ];

        return view('admin.dashboard.index', $data);
    }

    protected function getMonthlyAttendance(): array
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'present' => Attendance::whereMonth('date', $date->month)
                    ->whereYear('date', $date->year)
                    ->where('status', 'present')->count(),
                'absent' => Attendance::whereMonth('date', $date->month)
                    ->whereYear('date', $date->year)
                    ->where('status', 'absent')->count(),
                'late' => Attendance::whereMonth('date', $date->month)
                    ->whereYear('date', $date->year)
                    ->where('status', 'late')->count(),
            ];
        }
        return $months;
    }
}
