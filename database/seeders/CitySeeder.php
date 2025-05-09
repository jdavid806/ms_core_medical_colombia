<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'department_id' => Department::pluck('id')->random(),  // ID de un país existente (ajusta según tu base de datos)
                'name' => 'Ciudad de México',
                'area_code' => '555',
                'is_active' => 1,
            ],
            [
                'department_id' => Department::pluck('id')->random(),  // ID de otro país
                'name' => 'Buenos Aires',
                'area_code' => '11',
                'is_active' => 1,
            ],
            [
                'department_id' => Department::pluck('id')->random(),  // ID de otro país
                'name' => 'Madrid',
                'area_code' => '91',
                'is_active' => 1,
            ],
        ];

        foreach ($data as $item) {
            City::create($item);
        }
    }
}
