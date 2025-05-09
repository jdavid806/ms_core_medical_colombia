<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\InventoryService;
use App\Http\Controllers\Controller;
use App\Models\ExamRecipeDetail;
use Exception;
use Illuminate\Support\Facades\Http;
use App\Helpers\ExceptionHandlerHelper;
use Illuminate\Support\Facades\Log;

class ProductServiceController extends Controller
{

    protected string $baseUrl;

    public function __construct(private InventoryService $inventoryService)
    {
        $this->baseUrl = env('INVENTORY_SERVICE_URL', 'http://foo2.localhost:8000/api/v1/admin');
    }

    public function getAllProducts()
    {
        $services = $this->inventoryService->getProducts();
        return response()->json($services);
    }

    public function getAllProductsServices()
    {
        $services = $this->inventoryService->getProductsServices();
        return response()->json($services);
    }

    public function getByExamRecipeId($id)
    {
        $examTypeIdsByRecipes = ExamRecipeDetail::where('exam_recipe_id', $id)->pluck('exam_type_id')->toArray();

        try {
            $response = Http::post("{$this->baseUrl}/products/ByExamsType", ["exam_type_ids" => $examTypeIdsByRecipes]);

            if ($response->successful()) {

                return response()->json($response->json());
            }

            return ['error' => 'No hay productos disponibles con esos ids de tipos de examen'];
        } catch (Exception $e) {
            ExceptionHandlerHelper::throwException($e);
        }
    }
}
