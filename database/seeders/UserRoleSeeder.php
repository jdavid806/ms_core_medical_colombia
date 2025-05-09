<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Administrador',
                'is_active' => true,
            ],
            [
                'name' => 'Médico General',
                'is_active' => true,
            ],
            [
                'name' => 'Especialista',
                'is_active' => true,
            ],
            [
                'name' => 'Recepcionista',
                'is_active' => true,
            ],
            [
                'name' => 'Asistente Médico',
                'is_active' => true,
            ],
            [
                'name' => 'Enfermero',
                'is_active' => true,
            ],
            [
                'name' => 'Técnico de Laboratorio',
                'is_active' => true,
            ],
            [
                'name' => 'Farmacéutico',
                'is_active' => true,
            ],
            [
                'name' => 'Gerente de Clínica',
                'is_active' => true,
            ],
            [
                'name' => 'Personal de Limpieza',
                'is_active' => true,
            ],
        ];

        foreach ($data as $item) {
            UserRole::updateOrCreate($item);
        }
    }
}
