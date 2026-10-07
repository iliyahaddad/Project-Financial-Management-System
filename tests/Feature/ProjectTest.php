<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_list_requires_auth()
    {
        $this->get('/projects')->assertRedirect('/login');
    }

    public function test_project_list_loads_for_admin()
    {
        $user = User::factory()->withRole('super_admin')->create();
        $this->actingAs($user)->get('/projects')->assertOk();
    }

    public function test_project_create_page()
    {
        $user = User::factory()->withRole('super_admin')->create();
        $this->actingAs($user)->get('/projects/create')->assertOk();
    }

    public function test_project_store()
    {
        $user = User::factory()->withRole('super_admin')->create();
        $client = Client::factory()->create();

        $response = $this->actingAs($user)->post('/projects', [
            'project_code' => 'PRJ-0001',
            'project_name' => 'پروژه آزمایشی',
            'client_id' => $client->id,
            'project_manager_id' => $user->id,
            'status' => 'active',
            'priority' => 'medium',
            'progress_method' => 'manual',
            'currency' => 'IRR',
            'description' => 'توضیحات',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('projects', ['project_code' => 'PRJ-0001']);
    }
}
