<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Address;
use App\Models\Patient;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Antonio Orlando',
            'email' => 'orlando@example.com'
        ]);

        Patient::factory(30)->has(Address::factory(1))->create();

        Specialty::factory()->create([
            'name' => 'Oftalmo'
        ]);

        Specialty::factory()->create([
            'name' => 'Dentista'
        ]);

        Specialty::factory()->create([
            'name' => 'Clínico'
        ]);

        Specialty::factory()->create([
            'name' => 'Nutricionista'
        ]);
    }
}
