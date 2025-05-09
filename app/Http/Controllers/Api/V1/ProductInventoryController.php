<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Http\Controllers\Controller;

class ProductInventoryController extends Controller
{
    public function __construct(private InventoryService $inventoryService){}

    public function create(Request $request)
    {
        $data = $request->all();
        $product = $this->inventoryService->createProduct($data);
        return response()->json($product);
    }


    public function getProductById($id)
    {
        $product = $this->inventoryService->getProductById($id);
        return response()->json($product);
    }
}
