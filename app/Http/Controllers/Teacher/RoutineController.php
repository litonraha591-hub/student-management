<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoutine;
use Illuminate\Support\Facades\Auth;

class RoutineController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = strtolower(now()->englishDayOfWeek);

        $todayClasses = ClassRoutine::where('teacher_id', $userId)
            ->where('day', $today)
            ->with('class', 'section', 'subject')
            ->orderBy('start_time')
            ->get();

        $weeklyRoutine = ClassRoutine::where('teacher_id', $userId)
            ->with('class', 'section', 'subject')
            ->orderByRaw("FIELD(day, 'saturday','sunday','monday','tuesday','wednesday','thursday','friday')")
            ->orderBy('start_time')
            ->get();

        return view('teacher.routines.index', compact('todayClasses', 'weeklyRoutine'));
    }
}
