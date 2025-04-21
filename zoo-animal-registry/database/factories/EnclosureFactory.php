<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enclosure>
 */
class EnclosureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word . ' Enclosure',
            'limit' => $this->faker->numberBetween(1, 20),
            'feeding_at' => $this->faker->time('H:i:s'),
            'for_predators' => $this->faker->boolean(),
        ];
    }
}
