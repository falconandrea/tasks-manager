<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'project_id' => Project::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'priority' => $this->faker->randomElement(config('enum.priorities')),
            'status' => $this->faker->randomElement(config('enum.status')),
        ];
    }
}
