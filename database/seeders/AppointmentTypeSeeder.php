<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Presencial',
                'is_active' => 1,
            ],
            [
                'name' => 'Virtual',
                'is_active' => 1,
            ],
            [
                'name' => 'Domiciliaria',
                'is_active' => 1,
            ],
        ];

        foreach ($data as $item) {
            AppointmentType::updateOrCreate($item);
        }
    }
}
