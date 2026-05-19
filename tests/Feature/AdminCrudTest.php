<?php

namespace Tests\Feature;

use App\Models\{User, Field, Subject, Exam};
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'name' => 'Admin',
            'phone' => '0912345678',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }

    public function test_admin_can_create_field(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/fields', ['name' => 'مجال جديد', 'description' => 'وصف المجال'])
            ->assertRedirect();

        $this->assertDatabaseHas('fields', ['name' => 'مجال جديد']);
    }

    public function test_admin_can_create_subject(): void
    {
        $field = Field::create(['name' => 'تقنية', 'description' => 'وصف']);

        $this->actingAs($this->admin)
            ->post('/admin/subjects', ['name' => 'مادة جديدة', 'field_id' => $field->id, 'description' => 'وصف'])
            ->assertRedirect();

        $this->assertDatabaseHas('subjects', ['name' => 'مادة جديدة']);
    }

    public function test_admin_can_create_exam(): void
    {
        $field = Field::create(['name' => 'تقنية', 'description' => 'وصف']);
        $subject = Subject::create(['field_id' => $field->id, 'name' => 'برمجة', 'description' => 'وصف']);

        $this->actingAs($this->admin)
            ->post('/admin/exams', [
                'subject_id' => $subject->id,
                'exam_date' => now()->addDays(7)->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'max_students' => 30,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('exams', ['subject_id' => $subject->id]);
    }

    public function test_admin_cannot_delete_field_with_subjects(): void
    {
        $field = Field::create(['name' => 'تقنية', 'description' => 'وصف']);
        Subject::create(['field_id' => $field->id, 'name' => 'مادة', 'description' => 'وصف']);

        $this->actingAs($this->admin)
            ->delete("/admin/fields/{$field->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('fields', ['id' => $field->id]);
    }

    public function test_mass_assignment_protection_on_exam(): void
    {
        $field = Field::create(['name' => 'تقنية', 'description' => 'وصف']);
        $subject = Subject::create(['field_id' => $field->id, 'name' => 'برمجة', 'description' => 'وصف']);

        $this->actingAs($this->admin)
            ->post('/admin/exams', [
                'subject_id' => $subject->id,
                'exam_date' => now()->addDays(7)->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'max_students' => 30,
                'id' => 999, // Should be ignored
            ])
            ->assertRedirect();

        $exam = Exam::first();
        $this->assertNotEquals(999, $exam->id);
    }

    public function test_admin_can_create_user(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/users', [
                'name' => 'مدير جديد',
                'phone' => '0999999999',
                'password' => 'securepassword',
            ])
            ->assertRedirect();

        $newUser = User::where('phone', '0999999999')->first();
        $this->assertNotNull($newUser);
        $this->assertTrue($newUser->is_admin);
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $this->actingAs($this->admin)
            ->delete("/admin/users/{$this->admin->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }
}
