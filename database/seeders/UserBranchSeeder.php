<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use App\Models\UserBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id');
        $branches = Branch::pluck('id');

        if ($users->isEmpty() || $branches->isEmpty()) {
            $this->command->info('No hay usuarios o sucursales para crear relaciones.');
            return;
        }

        foreach ($users as $userId) {
            $randomBranches = $branches->random(rand(1, 3));

            foreach ($randomBranches as $branchId) {
                UserBranch::updateOrCreate(
                    ['user_id' => $userId, 'branch_id' => $branchId], // Condición para evitar duplicados
                    ['is_active' => 1]
                );
            }
        }
    }
}
