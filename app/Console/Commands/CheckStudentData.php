<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\LessonPlan;
use App\Models\Mark;
use App\Models\Student;
use App\Models\User;
use Illuminate\Console\Command;

class CheckStudentData extends Command
{
    protected $signature = 'check:student-data {--email=} {--student-id=}';
    protected $description = 'Check if student data is properly configured and has records';

    public function handle()
    {
        $email = $this->option('email');
        $studentId = $this->option('student-id');

        $student = null;

        if ($email) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error("User with email $email not found.");
                return;
            }
            $student = $user->student;
        } elseif ($studentId) {
            $student = Student::find($studentId);
        } else {
            $this->error('Please provide either --email or --student-id');
            return;
        }

        if (!$student) {
            $this->error('Student not found.');
            return;
        }

        $this->info('=== Student Information ===');
        $this->line("ID: {$student->id}");
        $this->line("Student ID: {$student->student_id}");
        $this->line("Name: {$student->user->name}");
        $this->line("Email: {$student->user->email}");
        $this->line("Role: {$student->user->role}");
        $this->line("Status: {$student->status}");

        $this->info('=== Class Assignment ===');
        if ($student->class_id) {
            $this->line("✓ Class: {$student->class->name}");
        } else {
            $this->error("✗ Class: NOT ASSIGNED");
        }

        if ($student->section_id) {
            $this->line("✓ Section: {$student->section->name}");
        } else {
            $this->error("✗ Section: NOT ASSIGNED");
        }

        $this->info('=== Data Records ===');

        $attendanceCount = Attendance::where('student_id', $student->id)->count();
        $this->line("Attendance Records: $attendanceCount");

        $marksCount = Mark::where('student_id', $student->id)->count();
        $this->line("Mark Records: $marksCount");

        if ($student->class_id && $student->section_id) {
            $assignmentsCount = Assignment::where('class_id', $student->class_id)
                ->where('section_id', $student->section_id)
                ->count();
            $this->line("Available Assignments: $assignmentsCount");

            $lessonPlansCount = LessonPlan::where('class_id', $student->class_id)
                ->where('section_id', $student->section_id)
                ->count();
            $this->line("Available Lesson Plans: $lessonPlansCount");
        } else {
            $this->error("Cannot check assignments/lesson plans - student not assigned to class/section");
        }

        $this->info('=== Recommendations ===');

        $issues = [];
        if (!$student->class_id) $issues[] = "Student not assigned to a class";
        if (!$student->section_id) $issues[] = "Student not assigned to a section";
        if ($attendanceCount === 0) $issues[] = "No attendance records created";
        if ($marksCount === 0) $issues[] = "No mark records created";

        if (empty($issues)) {
            $this->info("✓ All configurations look good!");
        } else {
            foreach ($issues as $issue) {
                $this->warn("- $issue");
            }
        }
    }
}
