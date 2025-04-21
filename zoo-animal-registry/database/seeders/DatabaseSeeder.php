<?php

namespace Database\Seeders;

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

        User::factory(10)->create();

        $this->call([
            EnclosureSeeder::class,
        ]);
    }
}
