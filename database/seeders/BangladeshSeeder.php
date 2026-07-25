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

class BangladeshSeeder extends Seeder
{
    public function run(): void
    {
        // Basic grade system (reuse names)
        $grades = [
            ['grade_name' => 'A+', 'min_marks' => 90, 'max_marks' => 100, 'gpa' => 4.00],
            ['grade_name' => 'A',  'min_marks' => 80, 'max_marks' => 89, 'gpa' => 3.70],
            ['grade_name' => 'A-', 'min_marks' => 75, 'max_marks' => 79, 'gpa' => 3.50],
            ['grade_name' => 'B+', 'min_marks' => 70, 'max_marks' => 74, 'gpa' => 3.30],
            ['grade_name' => 'B',  'min_marks' => 65, 'max_marks' => 69, 'gpa' => 3.00],
            ['grade_name' => 'C',  'min_marks' => 50, 'max_marks' => 59, 'gpa' => 2.00],
            ['grade_name' => 'D',  'min_marks' => 40, 'max_marks' => 49, 'gpa' => 1.00],
            ['grade_name' => 'F',  'min_marks' => 0,  'max_marks' => 39, 'gpa' => 0.00],
        ];
        foreach ($grades as $g) GradeSystem::create($g);

        // Super Admin
        $admin = User::firstOrCreate(['email' => 'admin@bd.sms'], ['name' => 'Super Admin BD', 'password' => Hash::make('password'), 'role' => 'super_admin']);

        // Departments common in Bangladesh schools
        $deptScience = Department::updateOrCreate(['code' => 'SCI'], ['name' => 'Science', 'description' => 'Science Department']);
        $deptBusiness = Department::updateOrCreate(['code' => 'BUS'], ['name' => 'Business Studies', 'description' => 'Business Studies Department']);

        // Classes 6 to 10
        $classes = [];
        $classNames = [6, 7, 8, 9, 10];
        foreach ($classNames as $num) {
            $cls = ClassModel::updateOrCreate(['name' => "Class $num"], ['department_id' => $deptScience->id]);
            $classes[$num] = $cls;
        }

        // Sections (A / B)
        $sections = [];
        foreach ($classes as $num => $cls) {
            $sections[$num]['A'] = Section::updateOrCreate(['name' => 'A', 'class_id' => $cls->id], ['name' => 'A', 'class_id' => $cls->id]);
            $sections[$num]['B'] = Section::updateOrCreate(['name' => 'B', 'class_id' => $cls->id], ['name' => 'B', 'class_id' => $cls->id]);
        }

        // Academic Year & Semesters
        $year = AcademicYear::updateOrCreate(['name' => '2025'], ['start_date' => '2025-01-01', 'end_date' => '2025-12-31', 'is_current' => true]);
        $semester1 = Semester::updateOrCreate(['academic_year_id' => $year->id, 'name' => 'Term 1'], ['start_date' => '2025-01-01', 'end_date' => '2025-06-30', 'is_current' => true]);
        $semester2 = Semester::updateOrCreate(['academic_year_id' => $year->id, 'name' => 'Term 2'], ['start_date' => '2025-07-01', 'end_date' => '2025-12-31', 'is_current' => false]);

        // Teachers (Bangladeshi names)
        $teacherUsers = [];
        $teacherData = [
            ['name' => 'Md. Rahim Uddin', 'email' => 'rahim@bd.sms', 'designation' => 'Assistant Teacher', 'qualification' => 'MSc Mathematics'],
            ['name' => 'Fatema Akter',    'email' => 'fatema@bd.sms', 'designation' => 'Lecturer', 'qualification' => 'MSc Physics'],
            ['name' => 'Dr. Jamal Hossain','email' => 'jamal@bd.sms', 'designation' => 'Professor', 'qualification' => 'PhD Chemistry'],
            ['name' => 'Amina Begum',     'email' => 'amina@bd.sms', 'designation' => 'Teacher', 'qualification' => 'MA English'],
            ['name' => 'Kamal Hassan',    'email' => 'kamal@bd.sms', 'designation' => 'Teacher', 'qualification' => 'BSc Computer Science'],
        ];
        foreach ($teacherData as $i => $td) {
            $u = User::firstOrCreate(['email' => $td['email']], ['name' => $td['name'], 'password' => Hash::make('password'), 'role' => 'teacher', 'phone' => '017000000' . $i]);
            
            Teacher::updateOrCreate(['user_id' => $u->id], ['employee_id' => 'BDT' . str_pad($i + 1, 4, '0', STR_PAD_LEFT), 'designation' => $td['designation'], 'qualification' => $td['qualification'], 'joining_date' => '2021-03-01']);
            $teacherUsers[] = $u;
        }

        // Subjects for Class 10
        $subjectData = [
            ['name' => 'Bangla', 'code' => 'BNG101'],
            ['name' => 'English', 'code' => 'ENG101'],
            ['name' => 'Mathematics', 'code' => 'MATH101'],
            ['name' => 'Physics', 'code' => 'PHY101'],
            ['name' => 'Chemistry', 'code' => 'CHEM101'],
        ];
        $subjects = [];
        foreach ($subjectData as $i => $sd) {
            $subjects[] = Subject::updateOrCreate(['code' => $sd['code']], ['name' => $sd['name'], 'class_id' => $classes[10]->id, 'teacher_id' => $teacherUsers[$i % count($teacherUsers)]->id, 'total_marks' => 100]);
        }

        // Students with Bangladeshi names
        $studentNames = [
            ['name' => 'Arif Islam', 'gender' => 'male'],
            ['name' => 'Sadia Parvin', 'gender' => 'female'],
            ['name' => 'Tanvir Ahmed', 'gender' => 'male'],
            ['name' => 'Mst. Nusrat', 'gender' => 'female'],
            ['name' => 'Rafiq Hossain', 'gender' => 'male'],
            ['name' => 'Nabila Khan', 'gender' => 'female'],
        ];

        $students = [];
        $stuCount = 0;
        foreach ($classes as $clsId => $cls) {
            foreach (['A', 'B'] as $secKey) {
                foreach ($studentNames as $i => $sd) {
                    $stuCount++;
                    $u = User::firstOrCreate(['email' => "student{$stuCount}@bd.sms"], ['name' => $sd['name'], 'password' => Hash::make('password'), 'role' => 'student', 'phone' => '01711' . str_pad($stuCount, 6, '0', STR_PAD_LEFT)]);
                    $s = Student::updateOrCreate([
                        'user_id' => $u->id,
                    ], [
                        'student_id' => 'BDSTU' . str_pad($stuCount, 5, '0', STR_PAD_LEFT),
                        'roll' => str_pad($stuCount % 30 + 1, 2, '0', STR_PAD_LEFT), 'gender' => $sd['gender'],
                        'father_name' => 'Md. Father', 'admission_date' => '2025-01-10', 'class_id' => $cls->id,
                        'section_id' => $sections[$clsId][$secKey]->id, 'academic_year_id' => $year->id,
                        'status' => 'active', 'address' => 'Dhaka, Bangladesh',
                    ]);
                    $students[] = $s;
                }
            }
        }

        // Simple notices
        Notice::create(['title' => 'স্বাগতম', 'content' => 'নতুন শিক্ষাবর্ষের জন্য সকলকে স্বাগতম।', 'visibility' => 'all', 'created_by' => $admin->id]);

        // Fees
        foreach ($classes as $cls) {
            Fee::create(['name' => 'Admission Fee', 'type' => 'admission', 'amount' => 2000, 'class_id' => $cls->id, 'academic_year_id' => $year->id]);
            Fee::create(['name' => 'Monthly Fee', 'type' => 'monthly', 'amount' => 1500, 'class_id' => $cls->id, 'academic_year_id' => $year->id]);
        }

        // Simple assignments
        Assignment::create(['title' => 'বাংলা বাড়ির কাজ', 'description' => 'অ্যাসাইনমেন্ট পড়ুন এবং লিখুন', 'subject_id' => $subjects[0]->id, 'class_id' => $classes[10]->id, 'section_id' => $sections[10]['A']->id, 'teacher_id' => $teacherUsers[0]->id, 'deadline' => '2025-02-10']);

        echo "Bangladesh demo data seeded.\n";
        echo "Login: admin@bd.sms / password\n";
    }
}
