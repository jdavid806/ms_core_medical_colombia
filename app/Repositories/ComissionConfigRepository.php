<?php

namespace App\Repositories;

use App\Models\ComissionConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ComissionConfigRepository extends BaseRepository
{
    protected string $productsApiUrl = 'http://dev.monaros.co/api/v1/admin/products';
    protected $model;

    public function __construct(ComissionConfig $model)
    {
        $this->model = $model;
    }

    public function getComissions()
    {
        try {
            $comissions = $this->model->with('services', 'user')->get();
            $products = $this->fetchProducts();

            return $this->mapProductsToComissions($comissions, $products);
        } catch (\Exception $e) {
            Log::error('Error fetching comission data: ' . $e->getMessage());
            return ['error' => 'Failed to load comission data', 'details' => $e->getMessage()];
        }
    }

    public function getComissionById($id)
    {
        try {
            // Obtener la comisión específica con sus relaciones
            $comission = $this->model->with('services', 'user')->findOrFail($id);
            $products = $this->fetchProducts();

            // Reutilizar la función de mapeo (aunque espera una colección)
            $mappedComission = $this->mapProductsToComissions(collect([$comission]), $products);

            // Devolver el primer elemento (y único) del array resultante
            return $mappedComission[0] ?? null;
        } catch (\Exception $e) {
            Log::error('Error fetching comission by ID: ' . $e->getMessage());
            return ['error' => 'Failed to load comission data', 'details' => $e->getMessage()];
        }
    }

    public function fetchProducts(): array
    {
        $response = Http::get($this->productsApiUrl);

        if (!$response->successful()) {
            throw new \RuntimeException('Failed to fetch products from API');
        }

        return $response->json()['data'] ?? [];
    }

    public function mapProductsToComissions($comissions, array $products)
    {
        return $comissions->map(function ($comission) use ($products) {
            $comission->services->each(function ($service) use ($products) {
                $service->product = collect($products)->firstWhere('id', $service->service_id);
            });
            return $comission;
        })->toArray();
    }
}
