<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sauna>
 */
class SaunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . 'サウナ',
            'postcode' => $this->faker->numerify('#######'),
            'prefecture' => $this->faker->randomElement(['東京都', '神奈川県', '埼玉県', '千葉県']),
            'city' => $this->faker->city(),
            'address' => $this->faker->streetAddress(),
            'sauna_temp' => $this->faker->numberBetween(80, 110),
            'water_temp' => $this->faker->numberBetween(10, 20),
            'has_loyly' => $this->faker->boolean(70),
            'description' => $this->faker->realText(100),
            'price' => $this->faker->numberBetween(500, 2000),
            'weekend_price' => $this->faker->numberBetween(800, 2500),
        ];
    }

    /**
     * has_loyly
     */
    public function hasLoyly(): static
    {
        return $this->state(fn (array $attributes) => [
            'has_loyly' => true,
        ]);
    }

    public function withImage(): static
    {
        return $this->has(
            \App\Models\Image::factory(),
            'images'
        );
    }
}
