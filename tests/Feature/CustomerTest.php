<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $userNotAuthorized;

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
    }

    /** @test */
    public function create_customer_without_required_field()
    {
        $response = $this->actingAs($this->user)->post('/api/customers', []);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function create_customer_with_success()
    {
        $response = $this->actingAs($this->user)->post('/api/customers', ['name' => 'Test user']);
        $response->assertStatus(201);
    }

    /** @test */
    public function create_customer_user_not_authorized()
    {
        $response = $this->actingAs($this->userNotAuthorized)->post('/api/customers', ['name' => 'Test user']);
        $response->assertStatus(403);
    }

    /** @test */
    public function get_customer_with_success()
    {
        $customer = Customer::factory()->create();
        $response = $this->actingAs($this->user)->get('/api/customers/' . $customer->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function get_customer_not_exists()
    {
        $response = $this->actingAs($this->user)->get('/api/customers/5');
        $response->assertStatus(404);
    }

    /** @test */
    public function update_customer_with_success()
    {
        $customer = Customer::factory()->create([
            'name' => 'Name 1'
        ]);
        $response = $this->actingAs($this->user)->patch('/api/customers/' . $customer->id, ['name' => 'Name 2']);
        $response->assertStatus(200);
        return $response->getOriginalContent()->name == 'Name 2';
    }
}
