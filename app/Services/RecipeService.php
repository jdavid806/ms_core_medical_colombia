<?php

namespace App\Services;

use App\Models\Recipe;
use App\DTOs\RecipeData;
use App\Repositories\RecipeRepository;

class RecipeService
{
    public function __construct(private RecipeRepository $recipeRepository, private RecipeItemService $recipeItemService) {}

    public function getAllRecipes()
    {
        return $this->recipeRepository->all();
    }

    public function getRecipeById(Recipe $recipe)
    {
        return $this->recipeRepository->find($recipe);
    }

    public function createRecipe(RecipeData $dto)
    {
        $recipe = $this->recipeRepository->create([
            'patient_id' => $dto->patientId,
            'user_id' => $dto->userId,
            'is_active' => $dto->isActive,
            'type' => $dto->type,
            'clinical_record_id' => $dto->clinicalRecordId,
        ]);
    
        if ($dto->type === 'general') {
            foreach ($dto->medicines as $medicine) {
                $medicine['recipe_id'] = $recipe->id;
                $this->recipeItemService->createRecipeItem($medicine);
            }
        }
    
        if ($dto->type === 'optometry') {
            $this->recipeItemService->createOptometryItem([
                'recipe_id' => $recipe->id,
                'data' => $dto->optometry, // se guarda en el campo JSON
            ]);
        }
    
        return $recipe;
    }

    

    public function updateRecipe(Recipe $recipe, array $data)
    {
        return $this->recipeRepository->update($recipe, $data);
    }

    public function deleteRecipe(Recipe $recipe)
    {
        return $this->recipeRepository->delete($recipe);
    }

    public function getLastPatientRecipe($patientId)
    {
        return $this->recipeRepository->getLastPatientRecipe($patientId);
    }

    public function updateStatus($id, $status)
    {
        if (!in_array($status, ['PENDING', 'VALIDATED', 'DELIVERED', 'PARTIALLY_DELIVERED', 'REJECTED'])) {
            throw new \InvalidArgumentException('Estado inválido.');
        }

        // Encontramos la receta por ID
        $recipe = $this->recipeRepository->findOrFail($id);
        
        // Actualizamos el estado de la receta
        $recipe->status = $status;

        // Guardamos los cambios
        $this->recipeRepository->save($recipe);
    }
}
