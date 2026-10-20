<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'name' => ucfirst(fake()->words(3, true)),
            'sku' => fake()->unique()->bothify('PRD-####-??'),
            'category' => fake()->randomElement(['Eletrônicos', 'Escritório', 'Casa', 'Esporte', 'Livros']),
            'description' => fake()->sentence(12),
            'price' => fake()->randomFloat(2, 5, 2500),
            'stock' => fake()->numberBetween(0, 200),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the product is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
