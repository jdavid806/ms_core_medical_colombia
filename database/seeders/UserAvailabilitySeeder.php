<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AppointmentType;
use App\Models\Branch;
use App\Models\UserAvailability;

class UserAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::pluck('id');
        $appointmentTypes = AppointmentType::pluck('id');
        $branches = Branch::pluck('id');
        $daysOfWeek = range(0, 6);

        foreach ($users as $user) {
            foreach ($appointmentTypes as $appointmentType) {
                $randomDays = collect($daysOfWeek)->random(rand(1, 3))->values(); // Obtiene entre 1 y 3 días como array JSON

                [$startTime, $endTime] = $this->randomTimeRange();

                $branchId = ($appointmentType == 1 && $branches->isNotEmpty()) ? $branches->random() : null;

                UserAvailability::updateOrCreate([
                    'user_id' => $user,
                    'appointment_type_id' => $appointmentType,
                    'appointment_duration' => 20,
                    'days_of_week' => json_encode($randomDays), // Guarda el array en formato JSON
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'branch_id' => $branchId,
                    'is_active' => true,
                ]);
            }
        }
    }

    /**
     * Genera un rango de tiempo válido para una disponibilidad de usuario.
     *
     * @return array [start_time, end_time]
     */
    private function randomTimeRange()
    {
        $startHour = rand(8, 17); // Horario de 8:00 a 17:00
        $endHour = rand($startHour + 1, 18); // Asegura que el fin sea después del inicio
        $startMinute = rand(0, 59);
        $endMinute = rand(0, 59);

        $startTime = sprintf('%02d:%02d', $startHour, $startMinute);
        $endTime = sprintf('%02d:%02d', $endHour, $endMinute);

        return [$startTime, $endTime];
    }
}
