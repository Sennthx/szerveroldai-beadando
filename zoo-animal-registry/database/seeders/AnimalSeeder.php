<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enclosure;

class AnimalSeeder extends Seeder
{

    public function run(): void
    {
        Enclosure::firstOrCreate(
            ['id' => 999],
            [
                'name' => 'Örök Vadászmezők',
                'limit' => 9999,
                'feeding_at' => '00:00:00',
            ]
        );
    }
}
