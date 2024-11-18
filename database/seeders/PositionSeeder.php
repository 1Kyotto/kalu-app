<?php

namespace Database\Seeders;

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
        DB::table('positions')->insert([
            ['id' => 1, 'name' => 'Administrativo'],
            ['id' => 2, 'name' => 'Repartidor'],
            ['id' => 3, 'name' => 'Operario'],
        ]);
    }
}
