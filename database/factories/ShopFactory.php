<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'cnpj' => fake()->unique()->sentence(),
            'slogan' => fake()->slug(6, true),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->sentence(),
            'address' => fake()->address(),
            'city' => fake()->city(),
        ];
    }
}
