<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin Nivel 1',
        ]);

        Role::create([
            'name' => 'Administrativo',
        ]);

        Role::create([
            'name' => 'Empleado',
        ]);
    }
}
