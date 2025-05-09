<?php

namespace App\Services\Api\V1;

use App\Models\RecipeItemOptometry;
use App\Exceptions\RecipeItemOptometryException;
use App\Repositories\RecipeItemOptometryRepository;
use Illuminate\Http\Response;

class RecipeItemOptometryService
{
    public function __construct(private RecipeItemOptometryRepository $recipeItemOptometryRepository) {}

    public function getAllRecipeItemOptometrys($filters, $perPage)
    {
        try {
            return RecipeItemOptometry::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new RecipeItemOptometryException('Failed to retrieve RecipeItemOptometrys', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRecipeItemOptometryById(RecipeItemOptometry $recipeItemOptometry)
    {
        $result = $this->recipeItemOptometryRepository->find($recipeItemOptometry);
        if (!$result) {
            throw new RecipeItemOptometryException('RecipeItemOptometry not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createRecipeItemOptometry(array $data)
    {
        try {
            return $this->recipeItemOptometryRepository->create($data);
        } catch (\Exception $e) {
            throw new RecipeItemOptometryException('Failed to create RecipeItemOptometry', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateRecipeItemOptometry(RecipeItemOptometry $recipeItemOptometry, array $data)
    {
        try {
            return $this->recipeItemOptometryRepository->update($recipeItemOptometry, $data);
        } catch (\Exception $e) {
            throw new RecipeItemOptometryException('Failed to update RecipeItemOptometry', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteRecipeItemOptometry(RecipeItemOptometry $recipeItemOptometry)
    {
        try {
            return $this->recipeItemOptometryRepository->delete($recipeItemOptometry);
        } catch (\Exception $e) {
            throw new RecipeItemOptometryException('Failed to delete RecipeItemOptometry', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}