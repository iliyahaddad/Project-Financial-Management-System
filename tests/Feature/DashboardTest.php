<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_loads()
    {
        $user = User::factory()->withRole('super_admin')->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('داشبورد مدیریت');
    }

    public function test_dashboard_shows_stats()
    {
        $user = User::factory()->withRole('super_admin')->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('تعداد پروژه‌ها');
    }
}
