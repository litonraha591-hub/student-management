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

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            ['grade_name' => 'A+', 'min_marks' => 90, 'max_marks' => 100, 'gpa' => 4.00],
            ['grade_name' => 'A',  'min_marks' => 80, 'max_marks' => 89,  'gpa' => 3.70],
            ['grade_name' => 'A-', 'min_marks' => 75, 'max_marks' => 79,  'gpa' => 3.50],
            ['grade_name' => 'B+', 'min_marks' => 70, 'max_marks' => 74,  'gpa' => 3.30],
            ['grade_name' => 'B',  'min_marks' => 65, 'max_marks' => 69,  'gpa' => 3.00],
            ['grade_name' => 'B-', 'min_marks' => 60, 'max_marks' => 64,  'gpa' => 2.70],
            ['grade_name' => 'C',  'min_marks' => 50, 'max_marks' => 59,  'gpa' => 2.00],
            ['grade_name' => 'D',  'min_marks' => 40, 'max_marks' => 49,  'gpa' => 1.00],
            ['grade_name' => 'F',  'min_marks' => 0,  'max_marks' => 39,  'gpa' => 0.00],
        ];

        foreach ($grades as $grade) {
            GradeSystem::updateOrCreate(
                ['grade_name' => $grade['grade_name']],
                $grade
            );
        }

        $admin = User::updateOrCreate(
            ['email' => 'admin@university.local'],
            ['name' => 'University Admin', 'password' => Hash::make('password'), 'role' => 'super_admin', 'phone' => '01800000000']
        );

        $departments = [
            'CSE' => ['name' => 'Computer Science & Engineering', 'description' => 'Faculty of Computer Science & Engineering'],
            'BBA' => ['name' => 'Business Administration', 'description' => 'Faculty of Business Administration'],
            'ENG' => ['name' => 'English Literature', 'description' => 'Faculty of English & Humanities'],
        ];

        $departmentModels = [];
        foreach ($departments as $code => $attributes) {
            $departmentModels[$code] = Department::updateOrCreate(
                ['code' => $code],
                array_merge(['code' => $code], $attributes)
            );
        }

        $classYears = [1 => 'Year 1', 2 => 'Year 2', 3 => 'Year 3', 4 => 'Year 4'];
        $classes = [];
        foreach ($classYears as $year => $name) {
            $classes[$year] = ClassModel::updateOrCreate(
                ['name' => $name],
                ['department_id' => $departmentModels['CSE']->id]
            );
        }

        $sections = [];
        foreach ($classes as $year => $class) {
            $sections[$year]['A'] = Section::updateOrCreate(
                ['name' => 'A', 'class_id' => $class->id],
                ['name' => 'A', 'class_id' => $class->id]
            );
            $sections[$year]['B'] = Section::updateOrCreate(
                ['name' => 'B', 'class_id' => $class->id],
                ['name' => 'B', 'class_id' => $class->id]
            );
        }

        $academicYear = AcademicYear::updateOrCreate(
            ['name' => '2025-2026'],
            ['start_date' => '2025-01-01', 'end_date' => '2026-12-31', 'is_current' => true]
        );

        $semester1 = Semester::updateOrCreate(
            ['academic_year_id' => $academicYear->id, 'name' => 'Semester 1'],
            ['start_date' => '2025-01-01', 'end_date' => '2025-06-30', 'is_current' => false]
        );

        $semester2 = Semester::updateOrCreate(
            ['academic_year_id' => $academicYear->id, 'name' => 'Semester 2'],
            ['start_date' => '2025-07-01', 'end_date' => '2025-12-31', 'is_current' => true]
        );

        $teacherData = [
            ['name' => 'Prof. Arif Rahman', 'email' => 'arif@university.local', 'designation' => 'Professor', 'qualification' => 'PhD Computer Science'],
            ['name' => 'Dr. Sabrina Khan', 'email' => 'sabrina@university.local', 'designation' => 'Associate Professor', 'qualification' => 'PhD Information Systems'],
            ['name' => 'Ms. Anika Islam', 'email' => 'anika@university.local', 'designation' => 'Assistant Professor', 'qualification' => 'MSc Software Engineering'],
            ['name' => 'Mr. Nabil Chowdhury', 'email' => 'nabil@university.local', 'designation' => 'Lecturer', 'qualification' => 'MBA Finance'],
            ['name' => 'Ms. Rina Akter', 'email' => 'rina@university.local', 'designation' => 'Lecturer', 'qualification' => 'MA English'],
            ['name' => 'Mr. Sumon Hossain', 'email' => 'sumon@university.local', 'designation' => 'Lecturer', 'qualification' => 'MSc Mathematics'],
        ];

        $teacherUsers = [];
        foreach ($teacherData as $index => $teacher) {
            $user = User::updateOrCreate(
                ['email' => $teacher['email']],
                ['name' => $teacher['name'], 'password' => Hash::make('password'), 'role' => 'teacher', 'phone' => '01800123' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)]
            );

            Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_id' => 'FAC' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'designation' => $teacher['designation'],
                    'qualification' => $teacher['qualification'],
                    'joining_date' => '2022-01-10',
                    'address' => 'University Campus, Dhaka',
                ]
            );

            $teacherUsers[] = $user;
        }

        $subjectData = [
            ['name' => 'Data Structures', 'code' => 'CSE301', 'class' => 3, 'teacher' => 0],
            ['name' => 'Database Systems', 'code' => 'CSE302', 'class' => 3, 'teacher' => 1],
            ['name' => 'Software Engineering', 'code' => 'CSE303', 'class' => 3, 'teacher' => 2],
            ['name' => 'Microeconomics', 'code' => 'BBA301', 'class' => 3, 'teacher' => 3],
            ['name' => 'Academic Writing', 'code' => 'ENG301', 'class' => 3, 'teacher' => 4],
        ];

        $subjects = [];
        foreach ($subjectData as $subject) {
            $subjects[] = Subject::updateOrCreate(
                ['code' => $subject['code']],
                ['name' => $subject['name'], 'class_id' => $classes[$subject['class']]->id, 'teacher_id' => $teacherUsers[$subject['teacher']]->id, 'total_marks' => 100]
            );
        }

        $studentNames = [
            ['name' => 'Aminul Islam', 'gender' => 'male'],
            ['name' => 'Shahana Akter', 'gender' => 'female'],
            ['name' => 'Tanveer Ahmed', 'gender' => 'male'],
            ['name' => 'Mst. Jannat', 'gender' => 'female'],
            ['name' => 'Rashedul Karim', 'gender' => 'male'],
            ['name' => 'Nusrat Jahan', 'gender' => 'female'],
        ];

        $students = [];
        $studentCount = 0;

        foreach ($classes as $year => $class) {
            foreach (['A', 'B'] as $sectionKey) {
                foreach ($studentNames as $nameData) {
                    $studentCount++;
                    $email = sprintf('student%02d@university.local', $studentCount);
                    $user = User::updateOrCreate(
                        ['email' => $email],
                        ['name' => $nameData['name'], 'password' => Hash::make('password'), 'role' => 'student', 'phone' => '01801111' . str_pad($studentCount, 2, '0', STR_PAD_LEFT)]
                    );

                    $students[] = Student::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'student_id' => 'UNI' . $academicYear->name . str_pad($studentCount, 4, '0', STR_PAD_LEFT),
                            'roll' => str_pad($studentCount, 2, '0', STR_PAD_LEFT),
                            'gender' => $nameData['gender'],
                            'father_name' => 'Md. Shahid ' . ($studentCount),
                            'mother_name' => 'Mrs. Fatima ' . ($studentCount),
                            'guardian_name' => 'Mr. Shahid ' . ($studentCount),
                            'guardian_phone' => '01802111' . str_pad($studentCount, 2, '0', STR_PAD_LEFT),
                            'address' => 'University Hall Area, Dhaka',
                            'emergency_contact' => '01803111' . str_pad($studentCount, 2, '0', STR_PAD_LEFT),
                            'registration_number' => 'REG' . $academicYear->name . str_pad($studentCount, 4, '0', STR_PAD_LEFT),
                            'admission_date' => '2025-01-15',
                            'status' => 'active',
                            'class_id' => $class->id,
                            'section_id' => $sections[$year][$sectionKey]->id,
                            'academic_year_id' => $academicYear->id,
                        ]
                    );
                }
            }
        }

        $year3Students = collect($students)->filter(function ($student) use ($classes) {
            return $student->class_id === $classes[3]->id;
        });

        $attendanceStatus = ['present', 'present', 'present', 'absent', 'present', 'present', 'late'];

        foreach ($year3Students as $student) {
            foreach ($subjects as $subject) {
                for ($day = 1; $day <= 10; $day++) {
                    Attendance::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'class_id' => $classes[3]->id,
                            'section_id' => $student->section_id,
                            'subject_id' => $subject->id,
                            'date' => "2025-02-" . str_pad($day, 2, '0', STR_PAD_LEFT),
                        ],
                        [
                            'status' => $attendanceStatus[array_rand($attendanceStatus)],
                            'marked_by' => $teacherUsers[0]->id,
                            'remarks' => null,
                        ]
                    );
                }
            }
        }

        $midtermExam = Exam::updateOrCreate(
            ['name' => 'Midterm Exam', 'academic_year_id' => $academicYear->id],
            ['type' => 'mid', 'semester_id' => $semester1->id, 'start_date' => '2025-03-01', 'end_date' => '2025-03-15']
        );

        $finalExam = Exam::updateOrCreate(
            ['name' => 'Final Exam', 'academic_year_id' => $academicYear->id],
            ['type' => 'final', 'semester_id' => $semester2->id, 'start_date' => '2025-06-01', 'end_date' => '2025-06-20']
        );

        foreach ($year3Students as $student) {
            foreach ($subjects as $subject) {
                $midTotal = rand(60, 95);
                $midGrade = GradeSystem::calculateGrade($midTotal);
                Mark::updateOrCreate(
                    ['student_id' => $student->id, 'subject_id' => $subject->id, 'exam_id' => $midtermExam->id],
                    [
                        'class_id' => $classes[3]->id,
                        'section_id' => $student->section_id,
                        'quiz_marks' => rand(10, 20),
                        'assignment_marks' => rand(10, 20),
                        'mid_marks' => rand(20, 40),
                        'final_marks' => 0,
                        'total_marks' => $midTotal,
                        'gpa' => $midGrade['gpa'] ?? null,
                        'grade' => $midGrade['grade_name'] ?? null,
                    ]
                );

                $finalTotal = rand(65, 100);
                $finalGrade = GradeSystem::calculateGrade($finalTotal);
                Mark::updateOrCreate(
                    ['student_id' => $student->id, 'subject_id' => $subject->id, 'exam_id' => $finalExam->id],
                    [
                        'class_id' => $classes[3]->id,
                        'section_id' => $student->section_id,
                        'quiz_marks' => rand(10, 20),
                        'assignment_marks' => rand(10, 20),
                        'mid_marks' => 0,
                        'final_marks' => rand(30, 50),
                        'total_marks' => $finalTotal,
                        'gpa' => $finalGrade['gpa'] ?? null,
                        'grade' => $finalGrade['grade_name'] ?? null,
                    ]
                );
            }
        }

        $notices = [
            ['title' => 'Orientation Week', 'content' => 'Orientation for new university students will take place on January 20, 2025.', 'visibility' => 'all'],
            ['title' => 'Library Opening Hours', 'content' => 'The central university library is open from 8:00 AM to 10:00 PM every weekday.', 'visibility' => 'all'],
            ['title' => 'Faculty Meeting', 'content' => 'All faculty members must attend the academic meeting on Monday at 3:00 PM.', 'visibility' => 'teachers'],
        ];

        foreach ($notices as $notice) {
            Notice::updateOrCreate(
                ['title' => $notice['title']],
                ['content' => $notice['content'], 'visibility' => $notice['visibility'], 'created_by' => $admin->id]
            );
        }

        Assignment::updateOrCreate(
            ['title' => 'Data Structures Project'],
            [
                'description' => 'Design and implement a simple student management system using linked lists.',
                'subject_id' => $subjects[0]->id,
                'class_id' => $classes[3]->id,
                'section_id' => $sections[3]['A']->id,
                'teacher_id' => $teacherUsers[0]->id,
                'deadline' => '2025-03-20',
            ]
        );

        Assignment::updateOrCreate(
            ['title' => 'Database Normalization Assignment'],
            [
                'description' => 'Normalize a sample university enrollment database up to 3NF.',
                'subject_id' => $subjects[1]->id,
                'class_id' => $classes[3]->id,
                'section_id' => $sections[3]['A']->id,
                'teacher_id' => $teacherUsers[1]->id,
                'deadline' => '2025-03-22',
            ]
        );

        Assignment::updateOrCreate(
            ['title' => 'Academic Writing Essay'],
            [
                'description' => 'Write a 1000-word essay on academic integrity.',
                'subject_id' => $subjects[4]->id,
                'class_id' => $classes[3]->id,
                'section_id' => $sections[3]['B']->id,
                'teacher_id' => $teacherUsers[4]->id,
                'deadline' => '2025-03-25',
            ]
        );

        foreach ($classes as $year => $class) {
            Fee::updateOrCreate(
                ['name' => 'Tuition Fee', 'class_id' => $class->id, 'academic_year_id' => $academicYear->id],
                ['type' => 'monthly', 'amount' => 15000]
            );
            Fee::updateOrCreate(
                ['name' => 'Library Fee', 'class_id' => $class->id, 'academic_year_id' => $academicYear->id],
                ['type' => 'other', 'amount' => 2000]
            );
        }

        $fee = Fee::where('name', 'Tuition Fee')->where('class_id', $classes[3]->id)->first();
        $year3StudentList = $year3Students->values();

        if ($fee && $year3StudentList->count() > 0) {
            FeePayment::updateOrCreate(
                ['fee_id' => $fee->id, 'student_id' => $year3StudentList[0]->id],
                ['amount_paid' => 15000, 'status' => 'paid', 'payment_date' => '2025-01-16', 'invoice_number' => 'INV-UNI-001']
            );
            if ($year3StudentList->count() > 1) {
                FeePayment::updateOrCreate(
                    ['fee_id' => $fee->id, 'student_id' => $year3StudentList[1]->id],
                    ['amount_paid' => 8000, 'status' => 'partial', 'payment_date' => '2025-01-18', 'invoice_number' => 'INV-UNI-002']
                );
            }
            if ($year3StudentList->count() > 2) {
                FeePayment::updateOrCreate(
                    ['fee_id' => $fee->id, 'student_id' => $year3StudentList[2]->id],
                    ['amount_paid' => 0, 'status' => 'pending', 'invoice_number' => 'INV-UNI-003']
                );
            }
        }

        $routineDays = ['Monday', 'Wednesday', 'Friday'];
        foreach ($routineDays as $dayIndex => $day) {
            foreach ([$sections[3]['A'], $sections[3]['B']] as $sectionIndex => $section) {
                ClassRoutine::updateOrCreate(
                    [
                        'class_id' => $classes[3]->id,
                        'section_id' => $section->id,
                        'subject_id' => $subjects[$sectionIndex]->id,
                        'day' => strtolower($day),
                    ],
                    [
                        'teacher_id' => $teacherUsers[$sectionIndex]->id,
                        'start_time' => sprintf('%02d:00', 9 + $dayIndex * 2),
                        'end_time' => sprintf('%02d:50', 9 + $dayIndex * 2),
                        'room' => 'Hall ' . ($sectionIndex + 1),
                    ]
                );
            }
        }
    }
}
