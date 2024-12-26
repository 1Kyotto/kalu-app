<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_user')->insert([
            // Admin Nivel 1
            ['users_id' => 1, 'roles_id' => 1],
            
            // Admin Nivel 2
            ['users_id' => 2, 'roles_id' => 2],
            
            // Usuarios normales (role 3 = User)
            ['users_id' => 3, 'roles_id' => 3],
            ['users_id' => 4, 'roles_id' => 3],
            ['users_id' => 5, 'roles_id' => 3],
            ['users_id' => 6, 'roles_id' => 3],
            ['users_id' => 7, 'roles_id' => 3],
            ['users_id' => 8, 'roles_id' => 3],
        ]);
    }
}
