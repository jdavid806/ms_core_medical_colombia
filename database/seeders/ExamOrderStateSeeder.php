<?php

namespace Database\Seeders;

use App\Models\ExamOrderState;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamOrderStateSeeder extends Seeder
{
    public function run(): void
    {
        // Definir los estados
        $states = [
            ['name' => 'pending'],
            ['name' => 'canceled'],
            ['name' => 'uploaded'],
            ['name' => 'generated']
        ];

        // Insertar los estados en la tabla exam_order_states
        foreach ($states as $state) {
            ExamOrderState::updateOrCreate(['name' => $state['name']], $state);
        }
    }
    
    
}
