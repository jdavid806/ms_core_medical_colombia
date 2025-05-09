<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Argentina', 'country_code' => 'AR', 'phone_code' => '+54', 'is_active' => 1],
            ['name' => 'Colombia', 'country_code' => 'CO', 'phone_code' => '+57', 'is_active' => 1],
            ['name' => 'Mexico', 'country_code' => 'MX', 'phone_code' => '+52', 'is_active' => 1],
            ['name' => 'Spain', 'country_code' => 'ES', 'phone_code' => '+34', 'is_active' => 1],
            ['name' => 'United States', 'country_code' => 'US', 'phone_code' => '+1', 'is_active' => 1],
            ['name' => 'France', 'country_code' => 'FR', 'phone_code' => '+33', 'is_active' => 1],
        ];

        foreach ($data as $item) {
            Country::create($item);
        }
    }
}
