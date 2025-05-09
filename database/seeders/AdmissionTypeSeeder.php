<?php

namespace Database\Seeders;

use App\Models\AdmissionType;
use Illuminate\Database\Seeder;

class AdmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'consultation', 'is_active' => true],
            ['name' => 'emergency', 'is_active' => true],
            ['name' => 'hospitalization', 'is_active' => true],
        ];

        foreach ($types as $type) {
            AdmissionType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
