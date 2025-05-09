<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regimes')->insert([
            [
                'name' => 'Contributivo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Subsidiado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
