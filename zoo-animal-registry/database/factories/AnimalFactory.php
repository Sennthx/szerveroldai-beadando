<?php

namespace Database\Factories;

use App\Models\Enclosure;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $predators = [
            'Lion', 'Tiger', 'Cheetah', 'Wolf', 'Eagle', 'Hawk',
            'Falcon', 'Snake', 'Crocodile', 'Bear', 'Owl', 'Lizard',
            'Alligator', 'Hyena', 'Jaguar', 'Leopard', 'Bobcat', 'Fox',
            'Scorpion', 'Komodo Dragon', 'Wolverine'
        ];

        $preys = [
            'Zebra', 'Elephant', 'Giraffe', 'Panda', 'Koala', 'Kangaroo',
            'Penguin', 'Dolphin', 'Whale', 'Gorilla', 'Parrot', 'Turtle',
            'Deer', 'Rabbit', 'Sheep', 'Goat', 'Capybara', 'Sloth',
            'Tapir', 'Meerkat', 'Flamingo', 'Manatee'
        ];

        $isPredator = $this->faker->boolean;

        $species = $isPredator
        ? $this->faker->randomElement($predators)
        : $this->faker->randomElement($preys);

        // Create or fetch enclosures for predators and non-predators
        $enclosure = $this->getOrCreateEnclosure($isPredator);

        return [
            'name' => $this->faker->name,
            'species' => $species,
            'is_predator' => $isPredator,
            'born_at' => $this->faker->dateTimeThisCentury(),
            'deleted_at' => null,
            'enclosure_id' => $enclosure->id,
            'image_name' => $this->faker->imageUrl(),
            'image_hash' => $this->faker->sha256,
        ];
    }


    /**
     * Helper method to return appropriate enclosure for predator or non-predator.
     *
     * @param bool $isPredator
     * @return \App\Models\Enclosure
     */
    protected function getEnclosureForAnimal(bool $isPredator): ?Enclosure {
        $enclosures = Enclosure::where('for_predators', $isPredator)
            ->where('id', '!=', 1) // special enclosure
            ->withCount(['animals' => function ($query) {
                $query->whereNull('deleted_at');
            }])
            ->get();

        $availableEnclosures = $enclosures->filter(function ($enclosure) {
            return $enclosure->animals_count < $enclosure->limit;
        });

        return $availableEnclosures->shuffle()->first();
    }

    private function getOrCreateEnclosure(bool $isPredator): Enclosure {
        return $this->getEnclosureForAnimal($isPredator) ?? Enclosure::factory()->create([
            'for_predators' => $isPredator,
            'limit' => rand(5, 10),
        ]);
    }
}
