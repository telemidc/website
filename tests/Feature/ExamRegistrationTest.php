<?php

namespace Tests\Feature;

use App\Models\{Exam, Subject, Field};
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExamRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function createExam(int $maxStudents = 30): Exam
    {
        $field = Field::create(['name' => 'تقنية المعلومات', 'description' => 'وصف']);
        $subject = Subject::create(['field_id' => $field->id, 'name' => 'البرمجة', 'description' => 'وصف']);
        return Exam::create([
            'subject_id' => $subject->id,
            'exam_date' => now()->addDays(7)->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'max_students' => $maxStudents,
        ]);
    }

    public function test_student_can_register_for_exam(): void
    {
        $exam = $this->createExam();

        $response = $this->post('/register-exam', [
            'exam_id' => $exam->id,
            'student_name' => 'طالب تجريبي',
            'country' => 'ليبيا',
            'email' => 'test@example.com',
            'phone' => '0912345678',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('exam_registrations', [
            'exam_id' => $exam->id,
            'student_name' => 'طالب تجريبي',
        ]);
    }

    public function test_student_cannot_register_when_exam_is_full(): void
    {
        $exam = $this->createExam(1);

        // First registration
        $this->post('/register-exam', [
            'exam_id' => $exam->id,
            'student_name' => 'طالب أول',
            'country' => 'ليبيا',
            'email' => 'first@example.com',
            'phone' => '0911111111',
        ]);

        // Second registration should fail
        $response = $this->post('/register-exam', [
            'exam_id' => $exam->id,
            'student_name' => 'طالب ثاني',
            'country' => 'ليبيا',
            'email' => 'second@example.com',
            'phone' => '0922222222',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_registration_validates_required_fields(): void
    {
        $exam = $this->createExam();

        $response = $this->post('/register-exam', [
            'exam_id' => $exam->id,
        ]);

        $response->assertSessionHasErrors(['student_name', 'country', 'email', 'phone']);
    }
}
