<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'IPhone '. fake()->numberBetween(5, 16),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(5, 50) * 1000,
        ];
    }
}
