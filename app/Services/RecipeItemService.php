<?php

namespace App\Services;

use App\Models\RecipeItem;
use App\Repositories\RecipeItemOptometryRepository;
use App\Repositories\RecipeItemRepository;

class RecipeItemService
{
    public function __construct(private RecipeItemRepository $recipeItemRepository, private RecipeItemOptometryRepository $recipeItemOptometryItemRepository) {}

    public function getAllRecipeItems()
    {
        return $this->recipeItemRepository->all();
    }

    public function getRecipeItemById(RecipeItem $recipeItem)
    {
        return $this->recipeItemRepository->find($recipeItem);
    }

    public function createRecipeItem(array $data)
    {
        return $this->recipeItemRepository->create($data);
    }

    public function createOptometryItem(array $data)
    {

        $dataOptometry = [
            'recipe_id' => $data['recipe_id'],
            'details' => $data['data'], // json
        ];
        return $this->recipeItemOptometryItemRepository->create($dataOptometry);
    }

    public function updateRecipeItem(RecipeItem $recipeItem, array $data)
    {
        return $this->recipeItemRepository->update($recipeItem, $data);
    }

    public function deleteRecipeItem(RecipeItem $recipeItem)
    {
        return $this->recipeItemRepository->delete($recipeItem);
    }
}
