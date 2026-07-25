<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\ClassRoutine;
use App\Models\Department;
use App\Models\Exam;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\GradeSystem;
use App\Models\Mark;
use App\Models\Notice;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Grade System
        $grades = [
            ['grade_name' => 'A+', 'min_marks' => 90, 'max_marks' => 100, 'gpa' => 4.00],
            ['grade_name' => 'A',  'min_marks' => 80, 'max_marks' => 89, 'gpa' => 3.70],
            ['grade_name' => 'A-', 'min_marks' => 75, 'max_marks' => 79, 'gpa' => 3.50],
            ['grade_name' => 'B+', 'min_marks' => 70, 'max_marks' => 74, 'gpa' => 3.30],
            ['grade_name' => 'B',  'min_marks' => 65, 'max_marks' => 69, 'gpa' => 3.00],
            ['grade_name' => 'B-', 'min_marks' => 60, 'max_marks' => 64, 'gpa' => 2.70],
            ['grade_name' => 'C',  'min_marks' => 50, 'max_marks' => 59, 'gpa' => 2.00],
            ['grade_name' => 'D',  'min_marks' => 40, 'max_marks' => 49, 'gpa' => 1.00],
            ['grade_name' => 'F',  'min_marks' => 0,  'max_marks' => 39, 'gpa' => 0.00],
        ];
        foreach ($grades as $g) GradeSystem::create($g);

        // Super Admin
        $admin = User::create(['name' => 'Super Admin', 'email' => 'admin@sms.com', 'password' => Hash::make('password'), 'role' => 'super_admin']);

        // Departments
        $deptScience = Department::create(['name' => 'Science', 'code' => 'SCI', 'description' => 'Science Department']);
        $deptArts = Department::create(['name' => 'Arts', 'code' => 'ARTS', 'description' => 'Arts Department']);

        // Classes 6 to 10
        $classes = [];
        $classNames = [6, 7, 8, 9, 10];
        foreach ($classNames as $num) {
            $cls = ClassModel::create(['name' => "Class $num", 'department_id' => $deptScience->id]);
            $classes[$num] = $cls;
        }

        // Shifts for each class (Morning / Afternoon)
        $shifts = [];
        foreach ($classNames as $num) {
            $shifts[$num] = [
                'morning' => Section::create(['name' => 'Morning Shift', 'class_id' => $classes[$num]->id]),
                'afternoon' => Section::create(['name' => 'Afternoon Shift', 'class_id' => $classes[$num]->id]),
            ];
        }

        // Academic Year & Semester
        $year = AcademicYear::create(['name' => '2024-2025', 'start_date' => '2024-01-01', 'end_date' => '2024-12-31', 'is_current' => true]);
        $semester1 = Semester::create(['academic_year_id' => $year->id, 'name' => 'Semester 1', 'start_date' => '2024-01-01', 'end_date' => '2024-06-30', 'is_current' => false]);
        $semester2 = Semester::create(['academic_year_id' => $year->id, 'name' => 'Semester 2', 'start_date' => '2024-07-01', 'end_date' => '2024-12-31', 'is_current' => true]);

        // Teachers
        $teacherUsers = [];
        $teacherData = [
            ['name' => 'Dr. Ahmed Khan',    'email' => 'teacher0@sms.com', 'designation' => 'Professor',          'qualification' => 'PhD Mathematics'],
            ['name' => 'Prof. Sara Ali',    'email' => 'teacher1@sms.com', 'designation' => 'Associate Professor','qualification' => 'MSc Physics'],
            ['name' => 'Mr. Hassan Raza',   'email' => 'teacher2@sms.com', 'designation' => 'Assistant Professor','qualification' => 'MSc Chemistry'],
            ['name' => 'Ms. Fatima Noor',   'email' => 'teacher3@sms.com', 'designation' => 'Lecturer',           'qualification' => 'MA English'],
            ['name' => 'Mr. Usman Malik',   'email' => 'teacher4@sms.com', 'designation' => 'Lecturer',           'qualification' => 'MCS Computer Science'],
            ['name' => 'Ms. Ayesha Khan',   'email' => 'teacher5@sms.com', 'designation' => 'Lecturer',           'qualification' => 'MSc Biology'],
        ];
        foreach ($teacherData as $i => $td) {
            $u = User::create(['name' => $td['name'], 'email' => $td['email'], 'password' => Hash::make('password'), 'role' => 'teacher', 'phone' => '0300-123456' . $i]);
            Teacher::create(['user_id' => $u->id, 'employee_id' => 'EMP' . str_pad($i + 1, 5, '0', STR_PAD_LEFT), 'designation' => $td['designation'], 'qualification' => $td['qualification'], 'joining_date' => '2020-01-15']);
            $teacherUsers[] = $u;
        }

        // Subjects for Class 9 (assigned to teachers)
        $subjectData = [
            ['name' => 'Mathematics',    'code' => 'MATH901'],
            ['name' => 'Physics',        'code' => 'PHY901'],
            ['name' => 'Chemistry',      'code' => 'CHEM901'],
            ['name' => 'English',        'code' => 'ENG901'],
            ['name' => 'Computer Science','code' => 'CS901'],
        ];
        $subjects = [];
        foreach ($subjectData as $i => $sd) {
            $subjects[] = Subject::create(['name' => $sd['name'], 'code' => $sd['code'], 'class_id' => $classes[9]->id, 'teacher_id' => $teacherUsers[$i]->id, 'total_marks' => 100]);
        }

        // Students across classes 6-10, both shifts
        $studentNames = [
            ['name' => 'Ali Hassan',     'gender' => 'male',   'roll' => '01', 'father' => 'Mr. Hassan Ali'],
            ['name' => 'Sara Malik',     'gender' => 'female', 'roll' => '02', 'father' => 'Mr. Malik Ahmed'],
            ['name' => 'Ahmed Raza',     'gender' => 'male',   'roll' => '03', 'father' => 'Mr. Raza Khan'],
            ['name' => 'Fatima Zahra',   'gender' => 'female', 'roll' => '04', 'father' => 'Mr. Zahra Hussain'],
            ['name' => 'Usman Tariq',    'gender' => 'male',   'roll' => '05', 'father' => 'Mr. Tariq Ali'],
            ['name' => 'Ayesha Siddiqui','gender' => 'female', 'roll' => '06', 'father' => 'Mr. Siddiqui'],
            ['name' => 'Bilal Ahmad',    'gender' => 'male',   'roll' => '07', 'father' => 'Mr. Ahmad Bilal'],
            ['name' => 'Hira Shah',      'gender' => 'female', 'roll' => '08', 'father' => 'Mr. Shah Khan'],
            ['name' => 'Kamran Saeed',   'gender' => 'male',   'roll' => '09', 'father' => 'Mr. Saeed Ahmed'],
            ['name' => 'Nadia Parveen',  'gender' => 'female', 'roll' => '10', 'father' => 'Mr. Parveen Ali'],
            ['name' => 'Omar Farooq',    'gender' => 'male',   'roll' => '11', 'father' => 'Mr. Farooq Shah'],
            ['name' => 'Zainab Bibi',    'gender' => 'female', 'roll' => '12', 'father' => 'Mr. Bibi Ahmed'],
        ];

        $students = [];
        $stuCount = 0;
        foreach ($classes as $clsId => $cls) {
            foreach (['morning', 'afternoon'] as $shiftType) {
                foreach ($studentNames as $i => $sd) {
                    $stuCount++;
                    $u = User::create(['name' => $sd['name'], 'email' => "student{$stuCount}@sms.com", 'password' => Hash::make('password'), 'role' => 'student', 'phone' => '0300-9876' . str_pad($stuCount % 100, 2, '0', STR_PAD_LEFT)]);
                    $s = Student::create([
                        'user_id' => $u->id, 'student_id' => 'STU' . str_pad($stuCount, 5, '0', STR_PAD_LEFT),
                        'roll' => $sd['roll'], 'gender' => $sd['gender'], 'father_name' => $sd['father'],
                        'admission_date' => '2024-01-15', 'class_id' => $cls->id,
                        'section_id' => $shifts[$clsId][$shiftType]->id, 'academic_year_id' => $year->id,
                        'status' => 'active', 'address' => '123 Main Street, Lahore',
                    ]);
                    $students[] = $s;
                }
            }
        }

        // Attendance (30 days) for Class 9 students only
        $class9Students = collect($students)->filter(fn($s) => $s->class_id == $classes[9]->id);
        foreach ($class9Students as $student) {
            foreach ($subjects as $subject) {
                for ($d = 1; $d <= 30; $d++) {
                    $statuses = ['present', 'present', 'present', 'present', 'absent', 'late', 'present', 'present'];
                    Attendance::create([
                        'student_id' => $student->id, 'class_id' => $classes[9]->id,
                        'section_id' => $student->section_id, 'subject_id' => $subject->id,
                        'date' => "2024-01-{$d}", 'status' => $statuses[array_rand($statuses)],
                        'marked_by' => $teacherUsers[0]->id,
                    ]);
                }
            }
        }

        // Exams - Mid Term and Final Term
        $midExam = Exam::create(['name' => 'Mid Term Exam', 'type' => 'mid', 'academic_year_id' => $year->id, 'semester_id' => $semester1->id, 'start_date' => '2024-03-01', 'end_date' => '2024-03-15']);
        $finalExam = Exam::create(['name' => 'Final Term Exam', 'type' => 'final', 'academic_year_id' => $year->id, 'semester_id' => $semester2->id, 'start_date' => '2024-06-01', 'end_date' => '2024-06-20']);

        // Marks for Class 9 students (both mid and final)
        foreach ($class9Students as $student) {
            foreach ($subjects as $subject) {
                // Mid term marks
                $quiz = rand(10, 20);
                $assign = rand(5, 10);
                $mid = rand(15, 30);
                $total = $quiz + $assign + $mid;
                $gradeData = \App\Models\GradeSystem::calculateGrade($total);
                Mark::create([
                    'student_id' => $student->id, 'subject_id' => $subject->id, 'exam_id' => $midExam->id,
                    'class_id' => $classes[9]->id, 'section_id' => $student->section_id,
                    'quiz_marks' => $quiz, 'assignment_marks' => $assign, 'mid_marks' => $mid, 'final_marks' => 0,
                    'total_marks' => $total, 'gpa' => $gradeData['gpa'] ?? null, 'grade' => $gradeData['grade'] ?? null,
                ]);

                // Final term marks
                $quiz2 = rand(10, 20);
                $assign2 = rand(5, 10);
                $final2 = rand(20, 40);
                $total2 = $quiz2 + $assign2 + $final2;
                $gradeData2 = \App\Models\GradeSystem::calculateGrade($total2);
                Mark::create([
                    'student_id' => $student->id, 'subject_id' => $subject->id, 'exam_id' => $finalExam->id,
                    'class_id' => $classes[9]->id, 'section_id' => $student->section_id,
                    'quiz_marks' => $quiz2, 'assignment_marks' => $assign2, 'mid_marks' => 0, 'final_marks' => $final2,
                    'total_marks' => $total2, 'gpa' => $gradeData2['gpa'] ?? null, 'grade' => $gradeData2['grade'] ?? null,
                ]);
            }
        }

        // Notices
        Notice::create(['title' => 'Welcome to New Semester', 'content' => 'We welcome all students to the new academic semester 2024-2025. Classes 6 to 10, both Morning and Afternoon shifts.', 'visibility' => 'all', 'created_by' => $admin->id]);
        Notice::create(['title' => 'Mid Term Exam Schedule', 'content' => 'Mid term examinations will begin from March 1st for all classes. Please prepare well.', 'visibility' => 'students', 'expiry_date' => '2024-04-01', 'created_by' => $admin->id]);
        Notice::create(['title' => 'Teacher Meeting', 'content' => 'All teachers are requested to attend the monthly meeting on Monday.', 'visibility' => 'teachers', 'created_by' => $admin->id]);
        Notice::create(['title' => 'Holiday Notice', 'content' => 'School will remain closed on Friday for national holiday.', 'visibility' => 'all', 'created_by' => $admin->id]);

        // Assignments
        Assignment::create(['title' => 'Math Homework Ch.1', 'description' => 'Complete exercises 1.1 to 1.5 from chapter 1', 'subject_id' => $subjects[0]->id, 'class_id' => $classes[9]->id, 'section_id' => $shifts[9]['morning']->id, 'teacher_id' => $teacherUsers[0]->id, 'deadline' => '2024-02-15']);
        Assignment::create(['title' => 'Physics Lab Report', 'description' => 'Write a lab report on the pendulum experiment', 'subject_id' => $subjects[1]->id, 'class_id' => $classes[9]->id, 'section_id' => $shifts[9]['morning']->id, 'teacher_id' => $teacherUsers[1]->id, 'deadline' => '2024-02-20']);
        Assignment::create(['title' => 'English Essay', 'description' => 'Write an essay on "My School" (500 words)', 'subject_id' => $subjects[3]->id, 'class_id' => $classes[9]->id, 'section_id' => $shifts[9]['afternoon']->id, 'teacher_id' => $teacherUsers[3]->id, 'deadline' => '2024-02-25']);

        // Fees for each class
        foreach ($classes as $clsId => $cls) {
            $feeAdmission = Fee::create(['name' => 'Admission Fee', 'type' => 'admission', 'amount' => 5000, 'class_id' => $cls->id, 'academic_year_id' => $year->id]);
            $feeMonthly = Fee::create(['name' => 'Monthly Fee', 'type' => 'monthly', 'amount' => 3000, 'class_id' => $cls->id, 'academic_year_id' => $year->id]);
        }

        // Fee payments for Class 9 students
        $class9FeeMonthly = Fee::where('class_id', $classes[9]->id)->where('type', 'monthly')->first();
        $class9StudentsValues = $class9Students->values();
        if ($class9StudentsValues->count() > 0) {
            FeePayment::create(['fee_id' => $class9FeeMonthly->id, 'student_id' => $class9StudentsValues[0]->id, 'amount_paid' => 3000, 'status' => 'paid', 'payment_date' => '2024-01-10', 'invoice_number' => 'INV-000001']);
            if ($class9StudentsValues->count() > 1) {
                FeePayment::create(['fee_id' => $class9FeeMonthly->id, 'student_id' => $class9StudentsValues[1]->id, 'amount_paid' => 1500, 'status' => 'partial', 'payment_date' => '2024-01-12', 'invoice_number' => 'INV-000002']);
            }
            if ($class9StudentsValues->count() > 2) {
                FeePayment::create(['fee_id' => $class9FeeMonthly->id, 'student_id' => $class9StudentsValues[2]->id, 'amount_paid' => 0, 'status' => 'pending', 'invoice_number' => 'INV-000003']);
            }
        }

        // Routines for Class 9
        $days = ['saturday', 'monday', 'wednesday'];
        foreach ($days as $day) {
            foreach ($subjects as $i => $subject) {
                if ($i >= 3) break;
                ClassRoutine::create([
                    'class_id' => $classes[9]->id, 'section_id' => $shifts[9]['morning']->id, 'subject_id' => $subject->id,
                    'teacher_id' => $teacherUsers[$i]->id, 'day' => $day,
                    'start_time' => sprintf('%02d:00', 8 + $i), 'end_time' => sprintf('%02d:50', 8 + $i),
                    'room' => 'Room ' . ($i + 1),
                ]);
                ClassRoutine::create([
                    'class_id' => $classes[9]->id, 'section_id' => $shifts[9]['afternoon']->id, 'subject_id' => $subject->id,
                    'teacher_id' => $teacherUsers[$i]->id, 'day' => $day,
                    'start_time' => sprintf('%02d:00', 13 + $i), 'end_time' => sprintf('%02d:50', 13 + $i),
                    'room' => 'Room ' . ($i + 4),
                ]);
            }
        }

        // Demo parent
        $parent = User::create(['name' => 'Parent Demo', 'email' => 'parent@sms.com', 'password' => Hash::make('password'), 'role' => 'parent']);

        echo "Database seeded successfully!\n";
        echo "Demo Login Credentials:\n";
        echo "Admin:   admin@sms.com / password\n";
        echo "Teacher: teacher0@sms.com / password\n";
        echo "Student: student1@sms.com / password (Class 9 Morning)\n";
        echo "Parent:  parent@sms.com / password\n";
    }
}
