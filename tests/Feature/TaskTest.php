<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $projectManager;
    protected $developer1;
    protected $developer2;
    protected $customerId;
    protected $projectId;
    protected $taskDeveloper1;
    protected $taskDeveloper2;

    public function setUp() :void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        // Project Manager
        $this->projectManager = User::factory()->create([
            'email' => 'project@test.test'
        ]);
        $this->projectManager->assignRole('project-manager');

        // Developer
        $this->developer1 = User::factory()->create([
            'email' => 'developer1@test.test'
        ]);
        $this->developer2 = User::factory()->create([
            'email' => 'developer2@test.test'
        ]);
        $this->developer1->assignRole('developer');
        $this->developer2->assignRole('developer');

        // Create customer
        $this->customerId = Customer::factory()->create();
        $this->customerId = $this->customerId->id;

        // Create project
        $this->projectId = Project::factory()->create(['customer_id' => $this->customerId]);
        $this->projectId = $this->projectId->id;

        // Task for developer 1
        $this->taskDeveloper1 = Task::create([
            'name' => 'Test task',
            'description' => "Task test for testing",
            'user_id' => $this->developer1->id,
            'status' => 'todo',
            'priority' => 'low',
            'project_id' => $this->projectId
        ]);

        // Task for developer2
        $this->taskDeveloper2 = Task::create([
            'name' => 'Test task 2',
            'description' => "Task test for testing",
            'user_id' => $this->developer2->id,
            'status' => 'todo',
            'priority' => 'low',
            'project_id' => $this->projectId
        ]);
    }

    /** @test */
    public function create_task_without_required_field()
    {
        $response = $this->actingAs($this->projectManager)->post('/api/tasks', []);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function create_task_with_success()
    {
        $response = $this->actingAs($this->projectManager)->post('/api/tasks', [
            'name' => 'Test task',
            'description' => "Task test for testing",
            'user_id' => $this->developer1->id,
            'status' => 'todo',
            'priority' => 'low',
            'project_id' => $this->projectId
        ]);
        $response->assertStatus(201);
    }

    /** @test */
    public function create_task_user_not_authorized()
    {
        $response = $this->actingAs($this->developer1)->post('/api/tasks', [
            'name' => 'Test task',
            'description' => "Task test for testing",
            'user_id' => $this->developer1->id,
            'status' => 'todo',
            'priority' => 'low',
            'project_id' => $this->projectId
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function get_task_with_success_from_develop()
    {
        $response = $this->actingAs($this->developer1)->get('/api/tasks/' . $this->taskDeveloper1->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function get_task_with_error_not_authorized()
    {
        $response = $this->actingAs($this->developer1)->get('/api/tasks/' . $this->taskDeveloper2->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function assign_task_with_success()
    {
        $response = $this->actingAs($this->projectManager)->patch('/api/tasks/' . $this->taskDeveloper1->id . '/assign', ['user_id' => $this->developer2->id]);
        $response->assertStatus(200);
    }

    /** @test */
    public function assign_task_with_error_not_authorized()
    {
        $response = $this->actingAs($this->developer1)->patch('/api/tasks/' . $this->taskDeveloper1->id . '/assign', ['user_id' => $this->developer2->id]);
        $response->assertStatus(403);
    }

    /** @test */
    public function change_status_task_with_success()
    {
        $response = $this->actingAs($this->developer1)->patch('/api/tasks/' . $this->taskDeveloper1->id . '/status', ['status' => 'progress']);
        $response->assertStatus(200);
    }

    /** @test */
    public function change_status_task_with_error_not_authorized()
    {
        $response = $this->actingAs($this->developer2)->patch('/api/tasks/' . $this->taskDeveloper1->id . '/status', ['status' => 'progress']);
        $response->assertStatus(403);
    }
}
