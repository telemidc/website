<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_authentication(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_admin_routes_require_is_admin(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'phone' => '0912345678',
            'password' => bcrypt('password123'),
            'is_admin' => false,
        ]);

        $this->actingAs($user);
        $response = $this->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_dashboard(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'phone' => '0912345678',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $this->actingAs($user);
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_user_can_access_exams(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'phone' => '0912345678',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $this->actingAs($user);
        $response = $this->get('/admin/exams');
        $response->assertStatus(200);
    }
}
