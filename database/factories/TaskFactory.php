<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'attachment' => null,
            'completed' => false,
            'created_at' => now(),
            'completed_at' => null,
            'updated_at' => now(),
            'deleted_at' => null,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
