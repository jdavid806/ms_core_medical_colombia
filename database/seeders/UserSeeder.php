<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserSpecialty;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

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
                'first_name' => 'Carlos',
                'middle_name' => 'Luis',
                'last_name' => 'Garcia',
                'second_last_name' => 'Garcia',
                'external_id' => 6,
                'user_role_id' => UserRole::pluck('id')->random(),
                'user_specialty_id' => UserSpecialty::pluck('id')->random(),
                'is_active' => 1,
                'country_id' => $countries[0]['name'], // Asignar el nombre del primer país
                'city_id' => $cities[0]['name'], // Asignar el nombre de la primera ciudad
                'gender' => 'MALE',
                'address' => 'Avenida Reforma 123, Ciudad de México',
                'phone' => '5555555555',
                'email' => 'Xs4H3@example.com',
            ],
            [
                'first_name' => 'Sandra',
                'middle_name' => 'Marcela',
                'last_name' => 'Garcia',
                'second_last_name' => 'Garcia',
                'external_id' => 5,
                'user_role_id' => UserRole::pluck('id')->random(),
                'user_specialty_id' => UserSpecialty::pluck('id')->random(),
                'is_active' => 1,
                'country_id' => $countries[0]['name'], // Asignar el nombre del primer país
                'city_id' => $cities[0]['name'], // Asignar el nombre de la primera ciudad
                'gender' => 'FEMALE',
                'address' => 'Avenida Reforma 123, Ciudad de México',
                'phone' => '5555555555',
                'email' => 'Xs4H3@example.com',
            ],
        ];
        foreach ($data as $item) {
            User::updateOrCreate($item);
        }
    }
}
