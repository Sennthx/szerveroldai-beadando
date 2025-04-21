<?php

namespace Database\Seeders;
use Carbon\Carbon;

use App\Models\Enclosure;
use Illuminate\Database\Seeder;

class EnclosureSeeder extends Seeder
{

    public function run(): void
    {

        $feedingTime = Carbon::createFromFormat('H:i:s', '00:00:00', 'Europe/Budapest')->format('H:i:s');

        Enclosure::firstOrCreate([
            'name' => 'Örök Vadászmezők',
        ], [
            'limit' => 9999,
            'feeding_at' => $feedingTime,
        ]);

        Enclosure::factory(8)->create();
    }
}
