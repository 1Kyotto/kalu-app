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
            'name' => 'Martín González',
            'rut' => '12345678-9',
            'email' => 'martin.gonzalez@example.com',
            'password' => bcrypt('password1'),
            'cellphone' => '987654321',
            'address' => 'Calle Falsa 123, Santiago, Chile',
        ]);

        User::create([
            'roles_id' => 1,
            'name' => 'Ana Pérez',
            'rut' => '12314357-7',
            'email' => 'ana.perez@example.com',
            'password' => bcrypt('password2'),
            'cellphone' => '923456789',
            'address' => 'Av. Libertador Bernardo OHiggins 456, Santiago, Chile',
        ]);

        User::create([
            'roles_id' => 2,
            'name' => 'Luis Fernández',
            'rut' => '16789428-3',
            'email' => 'luis.fernandez@example.com',
            'password' => bcrypt('password7'),
            'cellphone' => '+56 9 5678 9012',
            'address' => 'Calle Las Condes 1000, Santiago, Chile',
        ]);
        
        User::create([
            'roles_id' => 2,
            'name' => 'Marta López',
            'rut' => '22325012-5',
            'email' => 'marta.lopez@example.com',
            'password' => bcrypt('password8'),
            'cellphone' => '+56 9 6789 0123',
            'address' => 'Calle El Sol 321, Temuco, Chile',
        ]);
        
        User::create([
            'roles_id' => 2,
            'name' => 'Ricardo Herrera',
            'rut' => '19032775-1',
            'email' => 'ricardo.herrera@example.com',
            'password' => bcrypt('password9'),
            'cellphone' => '+56 9 7890 1234',
            'address' => 'Calle Santa Rosa 567, Valparaíso, Chile',
        ]);
        
        User::create([
            'roles_id' => 2,
            'name' => 'Valentina Díaz',
            'rut' => '16789428-3',
            'email' => 'valentina.diaz@example.com',
            'password' => bcrypt('password10'),
            'cellphone' => '+56 9 8901 2345',
            'address' => 'Av. Bernardo O\'Higgins 890, Antofagasta, Chile',
        ]);
        
        User::create([
            'roles_id' => 2,
            'name' => 'Tomás Vargas',
            'rut' => '22325012-5',
            'email' => 'tomas.vargas@example.com',
            'password' => bcrypt('password11'),
            'cellphone' => '+56 9 9012 3456',
            'address' => 'Calle Los Pinos 4321, Iquique, Chile',
        ]);
        
        User::create([
            'roles_id' => 2,
            'name' => 'Isabel Castro',
            'rut' => '19327830-0',
            'email' => 'isabel.castro@example.com',
            'password' => bcrypt('password12'),
            'cellphone' => '+56 9 0123 4567',
            'address' => 'Calle San Martín 6789, Arica, Chile',
        ]);
    }
}
