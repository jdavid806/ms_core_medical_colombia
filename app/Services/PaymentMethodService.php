<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Helpers\ExceptionHandlerHelper;

class PaymentMethodService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('INVENTORY_SERVICE_URL', 'http://foo2.localhost:8000/api/v1/admin');
    }

    public function getPaymentMethods()
    {
        try {
            $response = Http::get("{$this->baseUrl}/payment-methods");

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No hay métodos de pago disponibles'];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }
    }

    public function getProductById($id)
    {
        try {
            $response = Http::get("{$this->baseUrl}/products/{$id}");

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No se encontro el producto'];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }
    }

    public function getProductsServices()
    {
        try {
            $response = Http::get("{$this->baseUrl}/products-services");

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No hay servicios disponibles'];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }
    }

    public function createPaymentMethod(array $data)
    {
        try {

            $response = Http::post("{$this->baseUrl}/payment-methods", $data);

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No se pudo crear el método de pago', 'details' => $response->json()];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }
    }


    public function getAllProductsTypes()
    {
        try {
            $response = Http::get("{$this->baseUrl}/product-types");

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No hay tipos de productos disponibles'];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }

    }
}
