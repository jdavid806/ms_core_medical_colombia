<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Http\Controllers\Controller;

class ProductTypeInventoryController extends Controller
{
    public function __construct(private InventoryService $inventoryService){}
    public function index()
    {
        return $this->inventoryService->getAllProductsTypes();
    }
}
