<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Employed;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employed::whereBetween('id', [1, 7])->get();

        foreach ($employees as $employed) {
            Contract::create([
                'employees_id' => $employed->id,
                'pdf_url' => 'contracts/CONTRATO.pdf',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
