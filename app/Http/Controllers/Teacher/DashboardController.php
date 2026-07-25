<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\ClassRoutine;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->englishDayOfWeek;

        $todayClasses = ClassRoutine::where('teacher_id', $user->id)
            ->where('day', strtolower($today))
            ->with('class', 'section', 'subject')
            ->orderBy('start_time')
            ->get();

        $weeklyRoutine = ClassRoutine::where('teacher_id', $user->id)
            ->with('class', 'section', 'subject')
            ->orderByRaw("FIELD(day, 'saturday','sunday','monday','tuesday','wednesday','thursday','friday')")
            ->orderBy('start_time')
            ->get();

        $todayAttendance = Attendance::where('marked_by', $user->id)
            ->whereDate('date', now()->toDateString())
            ->count();

        $recentNotices = Notice::latest()->take(5)->get();
        $pendingAssignments = Assignment::where('teacher_id', $user->id)->where('deadline', '>=', now())->count();

        return view('teacher.dashboard.index', compact(
            'todayClasses', 'weeklyRoutine', 'todayAttendance',
            'recentNotices', 'pendingAssignments'
        ));
    }
}
