<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Exam;
use App\Models\TeacherApplication;
use App\Models\TeacherContract;
use App\Models\CourseRegistration;
use App\Models\ExamRegistration;
use App\Models\Certificate;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Fields (المجالات)
        $fields = [
            Field::create(['name' => 'تقنية المعلومات والبرمجة', 'description' => 'دورات وتدريب في مجالات البرمجة، الشبكات، وتطوير الويب.']),
            Field::create(['name' => 'إدارة الأعمال', 'description' => 'تطوير المهارات الإدارية، القيادة، والموارد البشرية.']),
            Field::create(['name' => 'التسويق الرقمي', 'description' => 'استراتيجيات التسويق الحديثة، إدارة الحملات الإعلانية، وتحليل البيانات.']),
            Field::create(['name' => 'التصميم الجرافيكي', 'description' => 'تصميم الهوية البصرية، واجهات المستخدم، والمونتاج.']),
            Field::create(['name' => 'اللغات الأجنبية', 'description' => 'دورات في اللغات الإنجليزية، الفرنسية، والإسبانية.'])
        ];

        // 2. Create Subjects (المواد الدراسية)
        $subjects = [
            Subject::create(['field_id' => $fields[0]->id, 'name' => 'برمجة الويب (Laravel)']),
            Subject::create(['field_id' => $fields[0]->id, 'name' => 'تطوير تطبيقات الموبايل (Flutter)']),
            Subject::create(['field_id' => $fields[1]->id, 'name' => 'أساسيات الموارد البشرية']),
            Subject::create(['field_id' => $fields[1]->id, 'name' => 'إدارة المشاريع (PMP)']),
            Subject::create(['field_id' => $fields[2]->id, 'name' => 'التسويق عبر السوشيال ميديا']),
            Subject::create(['field_id' => $fields[3]->id, 'name' => 'تصميم واجهات المستخدم (UI/UX)']),
            Subject::create(['field_id' => $fields[4]->id, 'name' => 'المحادثة باللغة الإنجليزية'])
        ];

        // 3. Create Courses (الدورات التدريبية)
        $courses = [
            Course::create([
                'field_id' => $fields[0]->id,
                'name' => 'دورة بناء تطبيقات الويب باستخدام Laravel 11',
                'description' => 'دورة عملية متكاملة لتعلم إطار العمل Laravel من الصفر وحتى الاحتراف.',
                'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(35)->format('Y-m-d'),
                'max_students' => 20,
                'is_visible' => true
            ]),
            Course::create([
                'field_id' => $fields[3]->id,
                'name' => 'دبلوم التصميم الجرافيكي المتقدم',
                'description' => 'احترف برامج Adobe (Photoshop, Illustrator, InDesign).',
                'start_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(60)->format('Y-m-d'),
                'max_students' => 15,
                'is_visible' => true
            ]),
            Course::create([
                'field_id' => $fields[1]->id,
                'name' => 'القيادة الفعالة وإدارة فرق العمل',
                'description' => 'تعلم مهارات القيادة وتوجيه الفرق لتحقيق الأهداف المؤسسية.',
                'start_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(25)->format('Y-m-d'),
                'max_students' => 50,
                'is_visible' => true
            ]),
        ];

        // 4. Create Exams (الامتحانات)
        $exams = [
            Exam::create([
                'subject_id' => $subjects[0]->id,
                'exam_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'max_students' => 50
            ]),
            Exam::create([
                'subject_id' => $subjects[5]->id,
                'exam_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => '16:30:00',
                'max_students' => 30
            ])
        ];

        // 5. Create Teacher Applications & Contracts (الأساتذة)
        $teachers = [
            TeacherApplication::create([
                'field_id' => $fields[0]->id,
                'name' => 'أيوب بوليفة',
                'email' => 'ayoub@example.com',
                'phone' => '0924123929',
                'bio' => 'مطور برمجيات ذو خبرة عالية',
                'status' => 'hired'
            ]),
            TeacherApplication::create([
                'field_id' => $fields[2]->id,
                'name' => 'خالد محمود',
                'email' => 'khaled@example.com',
                'phone' => '0911234567',
                'bio' => 'خبير في التسويق والمبيعات',
                'status' => 'hired'
            ]),
            TeacherApplication::create([
                'field_id' => $fields[4]->id,
                'name' => 'سارة أحمد',
                'email' => 'sara@example.com',
                'phone' => '0937654321',
                'bio' => 'مدرسة لغة إنجليزية معتمدة',
                'status' => 'pending'
            ]),
        ];

        TeacherContract::create([
            'teacher_application_id' => $teachers[0]->id,
            'start_date' => Carbon::now()->subMonths(1),
            'contract_duration' => 'سنة واحدة',
            'contract_text' => 'عقد توظيف بدوام كامل',
            'salary' => 1500.00
        ]);
        TeacherContract::create([
            'teacher_application_id' => $teachers[1]->id,
            'start_date' => Carbon::now()->subDays(5),
            'contract_duration' => '6 أشهر',
            'contract_text' => 'عقد توظيف بدوام جزئي',
            'salary' => 1200.00
        ]);

        // 6. Course Registrations (تسجيلات الطلاب)
        $studentNames = ['أحمد فتحي', 'محمد حسن', 'فاطمة الزهراء', 'زينب محمود', 'علي سليمان', 'عمر عبدالسلام', 'ليلى مراد', 'خديجة محمد'];
        foreach($studentNames as $index => $name) {
            CourseRegistration::create([
                'course_id' => $courses[$index % 3]->id,
                'student_name' => $name,
                'email' => 'student'.$index.'@example.com',
                'phone' => '09' . rand(10000000, 99999999),
                'country' => 'ليبيا'
            ]);
        }

        // 7. Exam Registrations
        foreach(array_slice($studentNames, 0, 4) as $index => $name) {
            ExamRegistration::create([
                'exam_id' => $exams[$index % 2]->id,
                'student_name' => $name,
                'email' => 'examstudent'.$index.'@example.com',
                'phone' => '09' . rand(10000000, 99999999),
                'country' => 'ليبيا'
            ]);
        }

        // 8. Certificates
        Certificate::create([
            'course_registration_id' => 1,
            'grade' => 'ممتاز',
            'notes' => 'طالب متميز',
            'issued_at' => Carbon::now()->subDays(2)
        ]);
        Certificate::create([
            'course_registration_id' => 2,
            'grade' => 'جيد جداً',
            'notes' => 'اجتاز بامتياز',
            'issued_at' => Carbon::now()->subDays(10)
        ]);
        Certificate::create([
            'course_registration_id' => 3,
            'grade' => 'جيد',
            'notes' => '',
            'issued_at' => Carbon::now()->subDays(5)
        ]);
    }
}
