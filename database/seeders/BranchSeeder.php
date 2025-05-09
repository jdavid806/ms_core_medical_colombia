<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\City;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = [
            [
                "id" => 1,
                "name" => "Afghanistan",
                "iso2" => "AF",
                "phonecode" => 93
            ],
        ];

        $departments = [
            [
                "id" => 1,
                "name" => "Afghanistan",
                "iso2" => "AF",
                "phonecode" => 93
            ]
        ];

        $cities = [
            [
                "id" => 38592,
                "name" => "Alaba Special Wereda",
                "state_id" => 1
            ],
        ];

        $data = [
            [
                'city_id' => $cities[0]['id'],  // ID de una ciudad existente (ajusta según tu base de datos)
                'address' => 'Avenida Reforma 123, Ciudad de México',
                'is_active' => 1,
            ],
            [
                'city_id' =>  $cities[0]['id'],// ID de otra ciudad
                'address' => 'Calle Figueroa 456, Buenos Aires',
                'is_active' => 1,
            ],
            [
                'city_id' => $cities[0]['id'],  // ID de otra ciudad
                'address' => 'Gran Vía 789, Madrid',
                'is_active' => 1,
            ],
            // Agrega más sucursales según sea necesario
        ];

        foreach ($data as $item) {
            Branch::create($item);
        }
    }
}
