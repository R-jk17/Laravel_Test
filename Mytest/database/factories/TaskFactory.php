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
        // Generate a random start date in the future
        $date_debut = $this->faker->dateTimeBetween('now', '+1 week');
        
        // Generate an end date that is always after the start date
        $date_fin = $this->faker->dateTimeBetween($date_debut->format('Y-m-d H:i:s'), '+2 weeks');

        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date_debut' => $date_debut, // Use the generated start date
            'date_fin' => $date_fin, // Use the generated end date
            'status' => $this->faker->randomElement(['pending', 'in-progress', 'completed', 'missing']), 
            'user_id' => User::factory(), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            // Generate a start date in the past
            $date_debut = $this->faker->dateTimeBetween('-20 days', '-15 days');
            // Ensure end date is after start date
            $date_fin = $this->faker->dateTimeBetween($date_debut->format('Y-m-d H:i:s'), '-10 days');

            return [
                'status' => 'completed',
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            // Set future dates for pending tasks
            $date_debut = $this->faker->dateTimeBetween('now', '+1 week');
            // Ensure end date is after start date
            $date_fin = $this->faker->dateTimeBetween($date_debut->format('Y-m-d H:i:s'), '+5 days');

            return [
                'status' => 'pending',
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
            ];
        });
    }

    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            // Generate a start date in the past
            $date_debut = $this->faker->dateTimeBetween('-10 days', 'now');
            // Ensure end date is after start date
            $date_fin = $this->faker->dateTimeBetween($date_debut->format('Y-m-d H:i:s'), '+20 days');

            return [
                'status' => 'in-progress',
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
            ];
        });
    }

    public function missing()
    {
        return $this->state(function (array $attributes) {
            // Set past dates for missing tasks
            $date_debut = $this->faker->dateTimeBetween('-20 days', '-15 days');
            // Ensure end date is before now
            $date_fin = $this->faker->dateTimeBetween($date_debut->format('Y-m-d H:i:s'), '-10 days');

            return [
                'status' => 'missing',
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
            ];
        });
    }
}
