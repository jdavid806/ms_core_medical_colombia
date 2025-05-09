<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Recipe;
use App\DTOs\RecipeData;
use Illuminate\Http\Request;
use App\Services\RecipeService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Recipe\RecipeResource;
use App\Http\Requests\Api\V1\Recipe\StoreRecipeRequest;
use App\Http\Requests\Api\V1\Recipe\UpdateRecipeRequest;

class RecipeController extends Controller
{
    public function __construct(private RecipeService $recipeService) {}

    public function index()
    {
        $recipes = $this->recipeService->getAllRecipes();
        return RecipeResource::collection($recipes->load(['patient', 'prescriber.specialty', 'recipeItems']));
    }

    public function store(StoreRecipeRequest $request)
    {
        $data = $request->validated();

    
        $dto = new RecipeData(
            patientId: $data['patient_id'],
            userId: $data['user_id'],
            isActive: $data['is_active'] ?? true,
            type: $data['type'],
            medicines: $data['medicines'] ?? [],
            optometry: $data['optometry'] ?? []
        );
    
        $recipe = $this->recipeService->createRecipe($dto);
    
        return response()->json([
            'message' => 'Recipe created successfully',
            'recipe' => $recipe,
        ]);
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe->load(['patient', 'prescriber.specialty', 'recipeItems']));
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $this->recipeService->updateRecipe($recipe, $request->validated());
        return response()->json([
            'message' => 'Recipe updated successfully',
        ]);
    }

    public function destroy(Recipe $recipe)
    {
        $this->recipeService->deleteRecipe($recipe);
        return response()->json([
            'message' => 'Recipe deleted successfully',
        ]);
    }

    public function getLastPatientRecipe($patientId)
    {
        $recipe = $this->recipeService->getLastPatientRecipe($patientId);
        return new RecipeResource($recipe->load(['patient', 'prescriber.specialty', 'recipeItems']));
    }

    public function updateStatus(Request $request, $id)
    {
        // Obtenemos el nuevo estado de la receta desde la solicitud
        $status = $request->input('status');
        
        // Llamamos al servicio para actualizar el estado
        $this->recipeService->updateStatus($id, $status);

        return response()->json(['message' => 'Estado de receta actualizado.']);
    }
}
