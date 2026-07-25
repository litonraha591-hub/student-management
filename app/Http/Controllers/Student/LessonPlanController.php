<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LessonPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonPlanController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()?->student;
        
        if (!$student || !$student->class_id || !$student->section_id) {
            return view('student.lesson-plans.index', [
                'plans' => collect(),
            ]);
        }

        $query = LessonPlan::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->with('subject', 'teacher')
            ->latest('plan_date');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $plans = $query->paginate(15);

        return view('student.lesson-plans.index', compact('plans'));
    }
}
