<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sauna_id' => \App\Models\Sauna::factory(),
            'type' => 'review',
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'is_public' => true,
        ];
    }
}
