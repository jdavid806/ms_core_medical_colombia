<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Helpers\ExceptionHandlerHelper;

class InvoiceService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('INVENTORY_SERVICE_URL', 'http://foo2.localhost:8000/api/v1/admin');
    }
}