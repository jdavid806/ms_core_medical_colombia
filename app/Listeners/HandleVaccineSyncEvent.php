<?php

namespace App\Listeners;

use App\Events\VaccineSyncEvent;
use App\Jobs\ProcessVaccineSync;
use Illuminate\Support\Facades\Log;

class HandleVaccineSyncEvent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VaccineSyncEvent $event): void
    {
        $batchSize = 100;
        $vaccineBatches = array_chunk($event->vaccineData, $batchSize);

        foreach ($vaccineBatches as $batch) {

            Log::info('Handling vaccine batch created event', [
                'vaccineBatchData' => $batch,
            ]);

            ProcessVaccineSync::dispatch($batch);
        }
    }

    public function failed(VaccineSyncEvent $event, \Throwable $exception): void
    {
        Log::error('Failed to process vaccine sync', [
            'vaccineData' => $event->vaccineData,
            'exception' => $exception->getMessage(),
        ]);
    }
}
