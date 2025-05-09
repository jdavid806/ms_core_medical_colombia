<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Helpers\ExceptionHandlerHelper;
use App\Models\ExamType;

class InventoryService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('INVENTORY_SERVICE_URL', 'http://foo2.localhost:8000/api/v1/admin');
    }

    public function getProducts()
    {
        try {
            $response = Http::get("{$this->baseUrl}/products");

            if ($response->successful()) {
                $responseData = $response->json();

                foreach ($responseData["data"] as &$product) {
                    $examTypeId = $product["attributes"]['exam_type_id'] ?? null;

                    $product["relationships"]['exam_type'] = $examTypeId
                        ? ExamType::find($examTypeId)
                        : null;
                }
                unset($product);

                return $responseData;
            }

            return ['error' => 'No hay productos disponibles'];
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

    public function createProduct(array $data)
    {
        try {

            $response = Http::post("{$this->baseUrl}/products", $data);

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'No se pudo crear el producto', 'details' => $response->json()];
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
