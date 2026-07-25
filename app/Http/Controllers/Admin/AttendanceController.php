<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('student.user', 'class', 'section', 'subject');

        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        if ($request->filled('section_id')) $query->where('section_id', $request->section_id);
        if ($request->filled('subject_id')) $query->where('subject_id', $request->subject_id);
        if ($request->filled('date')) $query->whereDate('date', $request->date);
        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)->whereYear('date', $date->year);
        }
        if ($request->filled('status')) $query->where('status', $request->status);

        $attendances = $query->latest('date')->paginate(20);
        $classes = ClassModel::all();
        $sections = Section::all();
        $subjects = Subject::all();

        return view('admin.attendance.index', compact('attendances', 'classes', 'sections', 'subjects'));
    }
}
