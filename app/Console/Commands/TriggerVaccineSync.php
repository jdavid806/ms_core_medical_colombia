<?php

namespace App\Console\Commands;

use App\Events\VaccineSyncEvent;
use Illuminate\Console\Command;

class TriggerVaccineSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trigger:vaccine-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simular la sincronización de vacunas';

    /**
     * Execute the console command.
     */
    public function handle()
    {        // Datos simulados de vacuna
        $vaccineData = [
            [
                'name' => 'Vacuna Mock Edit',
                'expiration_status' => 'expired',
                'inventory_identifier' => 'mock-12345',
            ],
            [
                'name' => 'Vacuna 2 Mock Edit',
                'expiration_status' => 'valid',
                'inventory_identifier' => 'mock-12347',
            ],
            [
                'name' => 'Vacuna 3 Mock Edit',
                'availability_status' => 'available',
                'inventory_identifier' => 'mock-12346',
                'is_active' => 0
            ]
        ];

        // Disparar el evento
        event(new VaccineSyncEvent($vaccineData));

        $this->info('Evento de creación de vacuna disparado!');
    }
}
