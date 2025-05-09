<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\SocialSecurity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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



        return [
            'document_type' => $this->faker->randomElement(['CC', 'CE', 'TI']),
            'document_number' => $this->faker->unique()->regexify('[0-9]{7,20}'),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'second_last_name' => $this->faker->optional()->lastName,
            'gender' => $this->faker->randomElement(['MALE', 'FEMALE', 'OTHER', 'INDETERMINATE']),
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
            'address' => $this->faker->optional()->address,
            'nationality' => $this->faker->optional()->country,
            'country_id' => $countries[0]['name'], // Asignar el nombre del primer país
            'department_id' => $departments[0]['name'], // Asignar el nombre del primer departamento
            'city_id' => $cities[0]['name'], // Asignar el nombre de la primera ciudad
            'whatsapp' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'social_security_id' => SocialSecurity::inRandomOrder()->first()->id,
            'civil_status' => $this->faker->firstName,
            'ethnicity' => $this->faker->firstName,
            'is_active' => $this->faker->boolean(),
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
        ];
    }
}
