<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class EmployedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            ['id' => 1, 'user_id' => 1, 'positions_id' => 1, 'date_entry' => '', 'status' => 'active'],
            ['id' => 2, 'user_id' => 2, 'positions_id' => 1, 'date_entry' => '', 'status' => 'active'],
            ['id' => 3, 'user_id' => 3, 'positions_id' => 2, 'date_entry' => '', 'status' => 'active'],
            ['id' => 4, 'user_id' => 4, 'positions_id' => 2, 'date_entry' => '', 'status' => 'active'],
            ['id' => 5, 'user_id' => 5, 'positions_id' => 3, 'date_entry' => '', 'status' => 'active'],
            ['id' => 6, 'user_id' => 6, 'positions_id' => 3, 'date_entry' => '', 'status' => 'active'],
            ['id' => 7, 'user_id' => 7, 'positions_id' => 3, 'date_entry' => '', 'status' => 'active'],
            ['id' => 8, 'user_id' => 8, 'positions_id' => 3, 'date_entry' => '', 'status' => 'active'],
        ]);
    }
}
