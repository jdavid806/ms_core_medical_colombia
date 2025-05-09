<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\RecipeItemOptometry;
use App\Filters\RecipeItemOptometryFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Services\Api\V1\RecipeItemOptometryService;
use App\Http\Resources\Api\V1\RecipeItemOptometry\RecipeItemOptometryResource;
use App\Http\Requests\Api\V1\RecipeItemOptometry\StoreRecipeItemOptometryRequest;
use App\Http\Requests\Api\V1\RecipeItemOptometry\UpdateRecipeItemOptometryRequest;

class RecipeItemOptometryController extends ApiController
{
    public function __construct(private RecipeItemOptometryService $recipeItemOptometryService) {}

    public function index(RecipeItemOptometryFilter $filters)
    {
        $perPage = request()->input('per_page', 10);

        $recipeItemOptometrys = $this->recipeItemOptometryService->getAllRecipeItemOptometrys($filters, $perPage);

        return $this->ok('RecipeItemOptometrys retrieved successfully', RecipeItemOptometryResource::collection($recipeItemOptometrys));
    }

    public function store(StoreRecipeItemOptometryRequest $request)
    {
        $recipeItemOptometry = $this->recipeItemOptometryService->createRecipeItemOptometry($request->validated());
        return $this->ok('RecipeItemOptometry created successfully', new RecipeItemOptometryResource($recipeItemOptometry));
    }

    public function show(RecipeItemOptometry $recipeItemOptometry)
    {
        return $this->ok('RecipeItemOptometry retrieved successfully', new RecipeItemOptometryResource($recipeItemOptometry));
    }

    public function update(UpdateRecipeItemOptometryRequest $request, RecipeItemOptometry $recipeItemOptometry)
    {
        $this->recipeItemOptometryService->updateRecipeItemOptometry($recipeItemOptometry, $request->validated());
        return $this->ok('RecipeItemOptometry updated successfully');
    }

    public function destroy(RecipeItemOptometry $recipeItemOptometry)
    {
        $this->recipeItemOptometryService->deleteRecipeItemOptometry($recipeItemOptometry);
        return $this->ok('RecipeItemOptometry deleted successfully');
    }
}