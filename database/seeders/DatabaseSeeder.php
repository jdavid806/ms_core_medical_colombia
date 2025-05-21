<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\SocialSecurity;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CopaymentRuleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClinicalRecordTypeSeeder::class,
            UserRoleSeeder::class,
            UserSpecialtySeeder::class,
            AppointmentStateSeeder::class,
            AppointmentReasonSeeder::class,
            AppointmentTypeSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            UserBranchSeeder::class,
            UserAvailabilitySeeder::class,
            ExamOrderStateSeeder::class,
            CopaymentRuleSeeder::class,
        ]);

        //Patient::factory()->count(10)->create();
    }
}
