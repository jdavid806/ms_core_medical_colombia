<?php

namespace Database\Seeders;

use App\Models\UserSpecialty;
use Illuminate\Database\Seeder;

class UserSpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Cardiología',
                'is_active' => true,
            ],
            [
                'name' => 'Pediatría',
                'is_active' => true,
            ],
            [
                'name' => 'Neurología',
                'is_active' => true,
            ],
            [
                'name' => 'Dermatología',
                'is_active' => true,
            ],
            [
                'name' => 'Ginecología',
                'is_active' => true,
            ],
            [
                'name' => 'Oncología',
                'is_active' => true,
            ],
            [
                'name' => 'Oftalmología',
                'is_active' => true,
            ],
            [
                'name' => 'Endocrinología',
                'is_active' => true,
            ],
            [
                'name' => 'Laboratorio',
                'is_active' => true,
            ],
            [
                'name' => 'Psiquiatría',
                'is_active' => true,
            ],
            [
                'name' => 'Administrador',
                'is_active' => true,
            ]
        ];

        foreach ($data as $item) {
            UserSpecialty::updateOrCreate($item, [
                'name' => $item['name'],
            ]);
        }
    }
}
