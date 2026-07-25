<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendance;
use App\Http\Controllers\Admin\ResultController as AdminResult;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\AssignmentController as AdminAssignment;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\GradeSystemController;
use App\Http\Controllers\Admin\RoutineController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController as AdminProfile;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendance;
use App\Http\Controllers\Teacher\ResultController as TeacherResult;
use App\Http\Controllers\Teacher\RoutineController as TeacherRoutine;
use App\Http\Controllers\Teacher\AssignmentController as TeacherAssignment;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfile;
use App\Http\Controllers\Teacher\ExamController as TeacherExam;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\AttendanceController as StudentAttendance;
use App\Http\Controllers\Student\ResultController as StudentResult;
use App\Http\Controllers\Student\AssignmentController as StudentAssignment;
use App\Http\Controllers\Student\ProfileController as StudentProfile;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Admin profile
    Route::get('profile', [AdminProfile::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminProfile::class, 'update'])->name('profile.update');
    Route::put('profile/password', [AdminProfile::class, 'changePassword'])->name('profile.password');

    // Academic Management
    Route::resource('academic-years', AcademicYearController::class)->except(['show']);
    Route::post('academic-years/{academicYear}/set-current', [AcademicYearController::class, 'setCurrent'])->name('academic-years.set-current');
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::resource('classes', ClassController::class)->except(['show']);
    Route::resource('sections', SectionController::class)->except(['show']);
    Route::resource('subjects', SubjectController::class)->except(['show']);
    Route::resource('semesters', SemesterController::class)->except(['show']);

    // Student Management
    Route::resource('students', StudentController::class);

    // Teacher Management
    Route::resource('teachers', TeacherController::class);

    // Attendance
    Route::get('attendance', [AdminAttendance::class, 'index'])->name('attendance.index');

    // Results
    Route::get('results', [AdminResult::class, 'index'])->name('results.index');
    Route::get('results/enter', [AdminResult::class, 'enterMarks'])->name('results.enter');
    Route::post('results/save', [AdminResult::class, 'saveMarks'])->name('results.save');
    Route::get('results/student/{studentId}', [AdminResult::class, 'showStudentResult'])->name('results.student');

    // Exams
    Route::resource('exams', ExamController::class);
    Route::get('exams/{exam}/schedule', [ExamController::class, 'schedule'])->name('exams.schedule');
    Route::post('exams/{exam}/schedule', [ExamController::class, 'storeSchedule'])->name('exams.schedule.store');
    Route::delete('exam-schedules/{schedule}', [ExamController::class, 'destroySchedule'])->name('exams.schedule.destroy');

    // Notices
    Route::resource('notices', NoticeController::class)->except(['show']);

    // Assignments
    Route::resource('assignments', AdminAssignment::class)->except(['edit', 'update']);

    // Fees
    Route::resource('fees', FeeController::class)->except(['show', 'edit', 'update']);
    Route::get('fees/{fee}/payments', [FeeController::class, 'payments'])->name('fees.payments');
    Route::post('fees/generate-invoice', [FeeController::class, 'generateInvoice'])->name('fees.generate-invoice');
    Route::post('fee-payments/{payment}/mark-paid', [FeeController::class, 'markPaid'])->name('fees.mark-paid');

    // Grade System
    Route::resource('grades', GradeSystemController::class)->except(['show']);

    // Routine
    Route::resource('routines', RoutineController::class)->except(['show', 'edit', 'update']);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/students', [ReportController::class, 'studentReport'])->name('reports.students');
    Route::get('reports/teachers', [ReportController::class, 'teacherReport'])->name('reports.teachers');
    Route::get('reports/attendance', [ReportController::class, 'attendanceReport'])->name('reports.attendance');
    Route::get('reports/results', [ReportController::class, 'resultReport'])->name('reports.results');
    Route::get('reports/fees', [ReportController::class, 'feeReport'])->name('reports.fees');
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
    Route::get('attendance', [TeacherAttendance::class, 'index'])->name('attendance.index');
    Route::get('attendance/mark', [TeacherAttendance::class, 'mark'])->name('attendance.mark');
    Route::post('attendance/store', [TeacherAttendance::class, 'store'])->name('attendance.store');
    Route::get('attendance/history', [TeacherAttendance::class, 'history'])->name('attendance.history');
    Route::put('attendance/update-status', [TeacherAttendance::class, 'updateStatus'])->name('attendance.update-status');
    Route::get('results', [TeacherResult::class, 'index'])->name('results.index');
    Route::get('results/enter', [TeacherResult::class, 'enterMarks'])->name('results.enter');
    Route::post('results/save', [TeacherResult::class, 'saveMarks'])->name('results.save');
    Route::get('routine', [TeacherRoutine::class, 'index'])->name('routine.index');
    Route::resource('assignments', TeacherAssignment::class)->except(['edit', 'update']);
    Route::get('profile', [TeacherProfile::class, 'edit'])->name('profile.edit');
    Route::put('profile', [TeacherProfile::class, 'update'])->name('profile.update');
    Route::put('profile/password', [TeacherProfile::class, 'changePassword'])->name('profile.password');
    Route::get('exams', [TeacherExam::class, 'index'])->name('exams.index');
    Route::get('exams/create', [TeacherExam::class, 'create'])->name('exams.create');
    Route::post('exams', [TeacherExam::class, 'store'])->name('exams.store');
    Route::get('exams/{exam}', [TeacherExam::class, 'show'])->name('exams.show');
    Route::get('lesson-plans', [\App\Http\Controllers\Teacher\LessonPlanController::class, 'index'])->name('lesson-plans.index');
    Route::get('lesson-plans/create', [\App\Http\Controllers\Teacher\LessonPlanController::class, 'create'])->name('lesson-plans.create');
    Route::post('lesson-plans', [\App\Http\Controllers\Teacher\LessonPlanController::class, 'store'])->name('lesson-plans.store');
    Route::get('lesson-plans/{lessonPlan}/edit', [\App\Http\Controllers\Teacher\LessonPlanController::class, 'edit'])->name('lesson-plans.edit');
    Route::put('lesson-plans/{lessonPlan}', [\App\Http\Controllers\Teacher\LessonPlanController::class, 'update'])->name('lesson-plans.update');
    Route::delete('lesson-plans/{lessonPlan}', [\App\Http\Controllers\Teacher\LessonPlanController::class, 'destroy'])->name('lesson-plans.destroy');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
    Route::get('attendance', [StudentAttendance::class, 'index'])->name('attendance.index');
    Route::get('results', [StudentResult::class, 'index'])->name('results.index');
    Route::get('results/marksheet/{examId}', [StudentResult::class, 'marksheet'])->name('results.marksheet');
    Route::get('assignments', [StudentAssignment::class, 'index'])->name('assignments.index');
    Route::get('assignments/{assignment}', [StudentAssignment::class, 'show'])->name('assignments.show');
    Route::post('assignments/{assignment}/submit', [StudentAssignment::class, 'submit'])->name('assignments.submit');
    Route::get('profile', [StudentProfile::class, 'edit'])->name('profile.edit');
    Route::put('profile', [StudentProfile::class, 'update'])->name('profile.update');
    Route::get('lesson-plans', [\App\Http\Controllers\Student\LessonPlanController::class, 'index'])->name('lesson-plans.index');
});
