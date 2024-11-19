<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'name' => 'Administrativo',
        ]);

        Position::create([
            'name' => 'Repartidor',
        ]);

        Position::create([
            'name' => 'Operario',
        ]);
    }
}
