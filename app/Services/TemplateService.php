<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Helpers\ExceptionHandlerHelper;

class TemplateService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('FIRMA_SERVICE_URL');
    }

    public function createTemplate(array $data)
    {
        try {
            $response = Http::post("{$this->baseUrl}/templates", $data);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'No se pudo crear el template', 'details' => $response->json()];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }
    }
}
