<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        User::create([
            'roles_id' => 1,
            'name' => $faker->name,
            'rut' => '11830853-k',
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Contraseña encriptada
            'cellphone' => $faker->phoneNumber,
            'address' => $faker->address,
            'date_registration' => $faker->date('Y-m-d', 'now'),
        ]);
    }
}
