<?php

namespace Database\Seeders;

use App\Models\AppointmentReason;
use Illuminate\Database\Seeder;

class AppointmentReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Chequeo Médico',
                'is_active' => 1,
            ],
            [
                'name' => 'Consulta General',
                'is_active' => 1,
            ],
            [
                'name' => 'Urgencias',
                'is_active' => 1,
            ],
            [
                'name' => 'Seguimiento de Tratamiento',
                'is_active' => 1,
            ],
            [
                'name' => 'Evaluación Preventiva',
                'is_active' => 1,
            ],
        ];

        foreach ($data as $item) {
            AppointmentReason::updateOrCreate($item);
        }
    }
}
