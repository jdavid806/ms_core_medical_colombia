<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Antioquia', 'country_id' => 1],
            ['name' => 'Cundinamarca', 'country_id' => 1],
            ['name' => 'Valle del Cauca', 'country_id' => 1],
            ['name' => 'California', 'country_id' => 2],
            ['name' => 'Texas', 'country_id' => 2],
            ['name' => 'Ontario', 'country_id' => 3],
            ['name' => 'Quebec', 'country_id' => 3],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'name' => $department['name'],
                'country_id' => $department['country_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
