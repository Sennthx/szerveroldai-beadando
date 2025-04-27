<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{

    public function run(): void
    {
        Animal::factory(50)->create();
    }
}
