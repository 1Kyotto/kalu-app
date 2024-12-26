<?php

namespace Database\Seeders;

use App\Models\Employed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Employed::create([
            'users_id' => 1,
            'positions_id' => 1,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
        Employed::create([
            'users_id' => 2,
            'positions_id' => 1,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
        Employed::create([
            'users_id' => 3,
            'positions_id' => 2,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
        Employed::create([
            'users_id' => 4,
            'positions_id' => 2,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
        Employed::create([
            'users_id' => 5,
            'positions_id' => 3,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
        Employed::create([
            'users_id' => 6,
            'positions_id' => 3,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
        Employed::create([
            'users_id' => 7,
            'positions_id' => 3,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
        Employed::create([
            'users_id' => 8,
            'positions_id' => 3,
            'entry_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => 'activo'
        ]);
    }
}
