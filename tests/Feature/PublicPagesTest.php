<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('مصادر التنمية');
    }

    public function test_homepage_loads_in_english(): void
    {
        $this->withSession(['locale' => 'en']);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Resources of Development');
    }

    public function test_language_switch(): void
    {
        $response = $this->get('/lang/en');
        $response->assertRedirect('/');
    }

    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('تسجيل الدخول');
    }
}
