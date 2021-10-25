<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CustomerSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class
        ]);
    }
}
