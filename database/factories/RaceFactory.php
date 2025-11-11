<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Race>
 */
class RaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'driver_id' => \App\Models\Driver::factory(),
            'placement' => $this->faker->numberBetween(1, 20),
            'mistake' => $this->faker->boolean(30), // 30% chance of mistake
            'team' => $this->faker->randomElement(['Team A', 'Team B', 'Team C', 'Team D']),
            'type' => $this->faker->randomElement(['Sprint', 'Feature', 'Endurance']),
            'engine' => $this->faker->randomElement(['V6', 'V8', 'V10', 'V12', 'Electric']),
        ];
    }
}
