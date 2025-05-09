<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Helpers\ExceptionHandlerHelper;
use Illuminate\Support\Facades\Log;

class EstimateService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('INVENTORY_SERVICE_URL');
    }

    public function getEstimates()
    {
        try {
            $response = Http::get("{$this->baseUrl}/estimates");

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No hay presupuestos disponibles'];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }
    }

    public function createEstimate(array $data)
    {
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])->post("{$this->baseUrl}/estimates", $data);

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No se pudo crear el presupuesto', 'details' => $response->json()];
        } catch (Exception $e) {
            return ['error' => 'No se pudo crear el presupuesto', 'details' => $e->getMessage()];
        }
    }
}
