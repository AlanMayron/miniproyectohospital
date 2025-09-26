<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
     
    $statuses = ['disponible','ocupada','mantenimiento'];

    return [
        'name'     => 'Sala ' . fake()->unique()->numberBetween(1, 99),
        'capacity' => fake()->numberBetween(1, 20),
        'status'   => fake()->randomElement($statuses),
    ];

   }
}
