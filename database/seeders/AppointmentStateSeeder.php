<?php

namespace Database\Seeders;

use App\Models\AppointmentState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'pending',
                'is_active' => 1,
            ],
            [
                'name' => 'pending_consultation',
                'is_active' => 1,
            ],
            [
                'name' => 'in_consultation',
                'is_active' => 1,
            ],
            [
                'name' => 'consultation_completed',
                'is_active' => 1,
            ],
            [
                'name' => 'cancelled',
                'is_active' => 1,
            ],
            [
                'name' => 'rescheduled',
                'is_active' => 1,
            ],
            [
                'name' => 'called',
                'is_active' => 1,
            ],
            [
                'name' => 'non-attendance',
                'is_active' => 1,
            ]
        ];

        foreach ($data as $item) {
            AppointmentState::updateOrCreate(
                ['name' => $item['name']], // Condición única para evitar duplicados
                ['is_active' => $item['is_active']]
            );
        }
    }
}
