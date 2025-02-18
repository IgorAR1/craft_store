<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'title' => fake()->title(),
            'description' => fake()->text(),
            'price'=> fake()->numberBetween(23,1000),
            'color' => fake()->colorName(),
            'quantity' => fake()->numberBetween(1,45),
            'img_url' => fake()->url(),
        ];
    }
}
