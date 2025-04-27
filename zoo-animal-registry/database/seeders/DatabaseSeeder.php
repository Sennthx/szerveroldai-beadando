<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Enclosure;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'q@q.hu',
            'password' => Hash::make('q'),
            'admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Super User',
            'email' => 'u@u.hu',
            'password' => Hash::make('u'),
            'admin' => false,
        ]);

        User::factory(10)->create();

        $users = User::all();

        $this->call(EnclosureSeeder::class);
        $enclosures = Enclosure::all();


        foreach ($users as $user) {
            if ($user->admin) {
                $user->enclosures()->attach($enclosures->pluck('id'));
            }
            $randomEnclosures = $enclosures
                ->where('id', '!=', 1)
                ->random(rand(2, 5))
                ->pluck('id');

            $user->enclosures()->attach($randomEnclosures);
        }

        $this->call([
            AnimalSeeder::class,
        ]);

        // simulate archived animals
        $animalsToArchive = Animal::inRandomOrder()->take(rand(2, 3))->get();
        foreach ($animalsToArchive as $animal) {
            $animal->archive();
        }
    }
}
