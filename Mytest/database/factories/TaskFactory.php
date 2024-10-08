<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


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
    protected $model = \App\Models\Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence, 
            'description' => $this->faker->paragraph, 
            'date_debut' => $this->faker->date(), 
            'date_fin' => $this->faker->date(), 
            'user_id' => User::factory(), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    
}
