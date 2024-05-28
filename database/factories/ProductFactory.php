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
            'product_name' => $this->faker->name,
            'price' => $this->faker->numberBetween(10, 100) * 1000,
            'stock' => $this->faker->numberBetween(1, 100),
            'expiry_date' => $this->faker->date($format = 'Y-m-d', $max = 'now +2 years')
        ];
    }
}
