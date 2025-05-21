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
            User::updateOrCreate(
                ['external_id' => $item['external_id']], // Condición para evitar duplicados
                [
                    'first_name' => $item['first_name'],
                    'middle_name' => $item['middle_name'],
                    'last_name' => $item['last_name'],
                    'second_last_name' => $item['second_last_name'],
                    'user_role_id' => $item['user_role_id'],
                    'user_specialty_id' => $item['user_specialty_id'],
                    'is_active' => $item['is_active'],
                    'country_id' => $item['country_id'],
                    'city_id' => $item['city_id'],
                    'gender' => $item['gender'],
                    'address' => $item['address'],
                    'phone' => $item['phone'],
                    'email' => $item['email'],
                ]
            );
        }
    }
}
