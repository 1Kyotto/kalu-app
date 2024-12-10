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
            'name' => 'Martín González',
            'rut' => '12345678-9',
            'email' => 'martin.gonzalez@example.com',
            'password' => bcrypt('password1'),
            'cellphone' => '987654321',
            'address' => 'Calle Falsa 123, Santiago, Chile',
        ]);

        User::create([
            'name' => 'Ana Pérez',
            'rut' => '12314357-7',
            'email' => 'ana.perez@example.com',
            'password' => bcrypt('password2'),
            'cellphone' => '923456789',
            'address' => 'Av. Libertador Bernardo OHiggins 456, Santiago, Chile',
        ]);

        User::create([
            'name' => 'Luis Fernández',
            'rut' => '20789546-4',
            'email' => 'luis.fernandez@example.com',
            'password' => bcrypt('password3'),
            'cellphone' => '956789012',
            'address' => 'Calle Las Condes 1000, Santiago, Chile',
        ]);

        User::create([
            'name' => 'Marta López',
            'rut' => '14850324-8',
            'email' => 'marta.lopez@example.com',
            'password' => bcrypt('password4'),
            'cellphone' => '967890123',
            'address' => 'Calle El Sol 321, Temuco, Chile',
        ]);

        User::create([
            'name' => 'Ricardo Herrera',
            'rut' => '19032775-1',
            'email' => 'ricardo.herrera@example.com',
            'password' => bcrypt('password5'),
            'cellphone' => '978901234',
            'address' => 'Calle Santa Rosa 567, Valparaíso, Chile',
        ]);

        User::create([
            'name' => 'Valentina Díaz',
            'rut' => '16789428-3',
            'email' => 'valentina.diaz@example.com',
            'password' => bcrypt('password6'),
            'cellphone' => '989012345',
            'address' => 'Av. Bernardo O\'Higgins 890, Antofagasta, Chile',
        ]);

        User::create([
            'name' => 'Tomás Vargas',
            'rut' => '22325012-5',
            'email' => 'tomas.vargas@example.com',
            'password' => bcrypt('password7'),
            'cellphone' => '990123456',
            'address' => 'Calle Los Pinos 4321, Iquique, Chile',
        ]);

        User::create([
            'name' => 'Isabel Castro',
            'rut' => '19327830-0',
            'email' => 'isabel.castro@example.com',
            'password' => bcrypt('password8'),
            'cellphone' => '901234567',
            'address' => 'Calle San Martín 6789, Arica, Chile',
        ]);
    }
}
