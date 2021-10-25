<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $projectManagerRole = Role::create(['name' => 'project-manager']);
        $developerRole = Role::create(['name' => 'developer']);

        // Give permissions
        $projectManagerRole->givePermissionTo(Permission::create(['name' => 'add customer']));
        $projectManagerRole->givePermissionTo(Permission::create(['name' => 'add project']));
        $projectManagerRole->givePermissionTo(Permission::create(['name' => 'add task']));
        $projectManagerRole->givePermissionTo(Permission::create(['name' => 'assign task']));
        $developerRole->givePermissionTo(Permission::create(['name' => 'change task status']));
    }
}
