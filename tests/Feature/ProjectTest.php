<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $userNotAuthorized;
    protected $customerId;

    public function setUp() :void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        // Project Manager
        $this->user = User::factory()->create([
            'email' => 'project@test.test'
        ]);
        $this->user->assignRole('project-manager');

        // Developer
        $this->userNotAuthorized = User::factory()->create([
            'email' => 'developer@test.test'
        ]);
        $this->userNotAuthorized->assignRole('developer');

        // Create customer
        $this->customerId = Customer::factory()->create();
        $this->customerId = $this->customerId->id;
    }

    /** @test */
    public function create_project_without_required_field()
    {
        $response = $this->actingAs($this->user)->post('/api/projects', []);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function create_project_with_wrong_customer_id()
    {
        $response = $this->actingAs($this->user)->post('/api/projects', ['name' => 'Test user', 'customer_id' => 5]);
        $response->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function create_project_with_success()
    {
        $response = $this->actingAs($this->user)->post('/api/projects', ['name' => 'Test user', 'customer_id' => $this->customerId]);
        $response->assertStatus(201);
    }

    /** @test */
    public function create_project_user_not_authorized()
    {
        $response = $this->actingAs($this->userNotAuthorized)->post('/api/projects', ['name' => 'Test user', 'customer_id' => $this->customerId]);
        $response->assertStatus(403);
    }

    /** @test */
    public function get_project_with_success()
    {
        $project = Project::factory()->create();
        $response = $this->actingAs($this->user)->get('/api/projects/' . $project->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function get_project_not_exists()
    {
        $response = $this->actingAs($this->user)->get('/api/projects/5');
        $response->assertStatus(404);
    }

    /** @test */
    public function update_project_with_success()
    {
        $project = Project::factory()->create([
            'name' => 'Project 1',
            'customer_id' => $this->customerId
        ]);
        $response = $this->actingAs($this->user)->patch('/api/projects/' . $project->id, ['name' => 'Project 2', 'customer_id' => $this->customerId]);
        $response->assertStatus(200);
        return $response->getOriginalContent()->name == 'Project 2';
    }
}
