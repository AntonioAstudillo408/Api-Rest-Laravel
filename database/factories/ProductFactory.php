<?php

namespace Database\Factories;

use App\Models\Product;
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
            'name' => fake()->word(),
            'description' => fake()->paragraph(1),
            'quantity' => fake()->numberBetween(1,10),
            'status' => fake()->randomElements( [Product::PRODUCTO_DISPONIBLE , Product::PRODUCTO_NO_DISPONIBLE]),
            'image' => fake()->word(),
            'seller_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
