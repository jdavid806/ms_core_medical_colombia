<?php

namespace Database\Seeders;

use App\Models\CopaymentRule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CopaymentRuleSeeder extends Seeder
{
   public function run()
    {
        $rules = [
            // 🔹 Reglas para consultas
            [
                'type_scheme' => 'contributory',
                'attention_type' => 'consultation',
                'category' => 'A',
                'value' => 4500,
                'type' => 'fixed',
            ],
            [
                'type_scheme' => 'contributory',
                'attention_type' => 'consultation',
                'category' => 'B',
                'value' => 11300,
                'type' => 'fixed',
            ],
            [
                'type_scheme' => 'contributory',
                'attention_type' => 'consultation',
                'category' => 'C',
                'value' => 41000,
                'type' => 'fixed',
            ],
            [
                'type_scheme' => 'subsidiary',
                'attention_type' => 'consultation',
                'level' => '1',
                'value' => 11,
                'type' => 'percentage',
            ],
            [
                'type_scheme' => 'subsidiary',
                'attention_type' => 'consultation',
                'level' => '2',
                'value' => 17,
                'type' => 'percentage',
            ],

            // 🔹 Reglas para procedimientos (Procedures)
            [
                'type_scheme' => 'contributory',
                'attention_type' => 'procedure',
                'category' => 'A',
                'value' => 10, // % del precio del procedimiento
                'type' => 'percentage',
            ],
            [
                'type_scheme' => 'contributory',
                'attention_type' => 'procedure',
                'category' => 'B',
                'value' => 20, // % del precio del procedimiento
                'type' => 'percentage',
            ],
            [
                'type_scheme' => 'contributory',
                'attention_type' => 'procedure',
                'category' => 'C',
                'value' => 30, // % del precio del procedimiento
                'type' => 'percentage',
            ],
            [
                'type_scheme' => 'subsidiary',
                'attention_type' => 'procedure',
                'level' => '2',
                'value' => 15, // % del precio del procedimiento
                'type' => 'percentage',
            ],
        ];

        foreach ($rules as $rule) {
            CopaymentRule::updateOrCreate($rule);
        }
    }
}
