<?php

namespace Tests\Feature;

use App\Models\{Course, Field};
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function createCourse(int $maxStudents = 30): Course
    {
        $field = Field::create(['name' => 'إدارة أعمال', 'description' => 'وصف']);
        return Course::create([
            'name' => 'دورة تدريبية',
            'field_id' => $field->id,
            'description' => 'وصف الدورة',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(14)->format('Y-m-d'),
            'is_visible' => true,
            'max_students' => $maxStudents,
        ]);
    }

    public function test_student_can_register_for_course(): void
    {
        $course = $this->createCourse();

        $response = $this->post('/register-course', [
            'course_id' => $course->id,
            'student_name' => 'طالب تجريبي',
            'country' => 'ليبيا',
            'email' => 'test@example.com',
            'phone' => '0912345678',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('course_registrations', [
            'course_id' => $course->id,
            'student_name' => 'طالب تجريبي',
        ]);
    }

    public function test_student_cannot_register_when_course_is_full(): void
    {
        $course = $this->createCourse(1);

        $this->post('/register-course', [
            'course_id' => $course->id,
            'student_name' => 'طالب أول',
            'country' => 'ليبيا',
            'email' => 'first@example.com',
            'phone' => '0911111111',
        ]);

        $response = $this->post('/register-course', [
            'course_id' => $course->id,
            'student_name' => 'طالب ثاني',
            'country' => 'ليبيا',
            'email' => 'second@example.com',
            'phone' => '0922222222',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('course_error');
    }
}
