<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;
use App\Models\Enclosure;

class AnimalSeeder extends Seeder
{

    public function run(): void
    {
        Animal::factory(15)->create();
    }
}
