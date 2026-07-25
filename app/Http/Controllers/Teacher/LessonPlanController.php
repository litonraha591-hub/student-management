<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\LessonPlan;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonPlanController extends Controller
{
    public function index()
    {
        $plans = LessonPlan::where('teacher_id', Auth::id())
            ->with('subject', 'class', 'section')
            ->latest('plan_date')
            ->paginate(15);

        return view('teacher.lesson-plans.index', compact('plans'));
    }

    public function create()
    {
        $user = Auth::user();
        $subjects = Subject::where('teacher_id', $user->id)->with('class')->get();
        $classIds = $subjects->pluck('class_id')->unique();
        $classes = ClassModel::whereIn('id', $classIds)->get();
        $sections = Section::whereIn('class_id', $classIds)->get();

        return view('teacher.lesson-plans.create', compact('subjects', 'classes', 'sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'plan_date' => 'required|date',
            'type' => 'required|in:mid,final',
            'academic_year' => 'nullable|string|max:50',
        ]);

        $validated['teacher_id'] = Auth::id();

        LessonPlan::create($validated);

        return redirect()->route('teacher.lesson-plans.index')->with('success', 'Lesson plan created successfully.');
    }

    public function edit(LessonPlan $lessonPlan)
    {
        abort_unless($lessonPlan->teacher_id === Auth::id(), 403);

        $user = Auth::user();
        $subjects = Subject::where('teacher_id', $user->id)->with('class')->get();
        $classIds = $subjects->pluck('class_id')->unique();
        $classes = ClassModel::whereIn('id', $classIds)->get();
        $sections = Section::whereIn('class_id', $classIds)->get();

        return view('teacher.lesson-plans.edit', compact('lessonPlan', 'subjects', 'classes', 'sections'));
    }

    public function update(Request $request, LessonPlan $lessonPlan)
    {
        abort_unless($lessonPlan->teacher_id === Auth::id(), 403);

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'plan_date' => 'required|date',
            'type' => 'required|in:mid,final',
            'academic_year' => 'nullable|string|max:50',
        ]);

        $lessonPlan->update($validated);

        return redirect()->route('teacher.lesson-plans.index')->with('success', 'Lesson plan updated successfully.');
    }

    public function destroy(LessonPlan $lessonPlan)
    {
        abort_unless($lessonPlan->teacher_id === Auth::id(), 403);

        $lessonPlan->delete();
        return redirect()->route('teacher.lesson-plans.index')->with('success', 'Lesson plan deleted successfully.');
    }
}
