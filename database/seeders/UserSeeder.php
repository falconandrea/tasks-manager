<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create project manager user
        $projectManager = User::factory()->create([
            'name' => 'Project Manager User',
            'email' => 'manager@test.test',
        ]);
        $projectManager->assignRole('project-manager');

        // Create developer user
        $developer = User::factory()->create([
            'name' => 'Developer User',
            'email' => 'developer@test.test',
        ]);
        $developer->assignRole('developer');

        // Create a second developer user
        $developer2 = User::factory()->create([
            'name' => 'Developer User 2',
            'email' => 'developer2@test.test',
        ]);
        $developer2->assignRole('developer');
    }
}
