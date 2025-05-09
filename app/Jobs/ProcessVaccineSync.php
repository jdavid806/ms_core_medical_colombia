<?php

namespace App\Jobs;

use App\Services\VaccineService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessVaccineSync implements ShouldQueue
{
    use Queueable;

    protected $vaccineData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $vaccineData)
    {
        $this->vaccineData = $vaccineData;
    }

    /**
     * Execute the job.
     */
    public function handle(VaccineService $vaccineService): void
    {
        Log::info('Processing vaccine sync', [
            'vaccineData' => $this->vaccineData[0]
        ]);
        $vaccineService->syncVaccines($this->vaccineData[0]);
    }
}
