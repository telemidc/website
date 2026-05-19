<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_valid_credentials(): void
    {
        $user = User::create([
            'name' => 'Test Admin',
            'phone' => '0912345678',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $response = $this->post('/login', [
            'phone' => '0912345678',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin/exams');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_invalid_credentials(): void
    {
        User::create([
            'name' => 'Test Admin',
            'phone' => '0912345678',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $response = $this->post('/login', [
            'phone' => '0912345678',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_logout(): void
    {
        $user = User::create([
            'name' => 'Test Admin',
            'phone' => '0912345678',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
