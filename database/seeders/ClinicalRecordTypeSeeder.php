<?php

namespace Database\Seeders;

use App\Models\ClinicalRecordType;
use Illuminate\Database\Seeder;

class ClinicalRecordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key_' => 'PAST_MEDICAL_HISTORY',
                'name' => 'Antecedentes',
                'description' => 'General medical consultation record',
                'form_config' => json_encode(['fields' => ['symptoms', 'diagnosis', 'treatment']]),
                'is_active' => 1,
            ],
            [
                'key_' => 'CR002',
                'name' => 'Pediatría',
                'description' => 'Pediatric medical record',
                'form_config' => json_encode(['fields' => ['child_name', 'age', 'vaccination_status']]),
                'is_active' => 1,
            ],
            [
                'key_' => 'CR003',
                'name' => 'Dermatología',
                'description' => 'Dermatology consultation record',
                'form_config' => json_encode(['fields' => ['skin_condition', 'treatment_plan']]),
                'is_active' => 1,
            ],
        ];

        foreach ($data as $item) {
            ClinicalRecordType::create($item);
        }
    }
}
