<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\RecipeItem;
use Illuminate\Http\Request;
use App\Services\RecipeItemService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\RecipeItem\RecipeItemResource;
use App\Http\Requests\Api\V1\RecipeItem\StoreRecipeItemRequest;
use App\Http\Requests\Api\V1\RecipeItem\UpdateRecipeItemRequest;

class RecipeItemController extends Controller
{
    public function __construct(private RecipeItemService $recipeItemService) {}

    public function index()
    {
        $recipeItems = $this->recipeItemService->getAllRecipeItems();
        return RecipeItemResource::collection($recipeItems);
    }

    public function store(StoreRecipeItemRequest $request)
    {
        $recipeItem = $this->recipeItemService->createRecipeItem($request->validated());
        return response()->json([
            'message' => 'RecipeItem created successfully',
            'RecipeItem' => $recipeItem,
        ]);
    }

    public function show(RecipeItem $recipeItem)
    {
        return new RecipeItemResource($recipeItem);
    }

    public function update(UpdateRecipeItemRequest $request, RecipeItem $recipeItem)
    {
        $this->recipeItemService->updateRecipeItem($recipeItem, $request->validated());
        return response()->json([
            'message' => 'RecipeItem updated successfully',
        ]);
    }

    public function destroy(RecipeItem $recipeItem)
    {
        $this->recipeItemService->deleteRecipeItem($recipeItem);
        return response()->json([
            'message' => 'RecipeItem deleted successfully',
        ]);
    }

    //
}
