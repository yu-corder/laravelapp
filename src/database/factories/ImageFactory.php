<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_path' => 'saunas/' . $this->faker->uuid() . '.jpg',
            'display_order' => 0,
            'imageable_type' => \App\Models\Sauna::class,
            'imageable_id' => \App\Models\Sauna::factory(),
        ];
    }
}
