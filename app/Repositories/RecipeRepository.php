<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository extends BaseRepository
{
    const RELATIONS = ['patient', 'prescriber', 'recipeItems'];

    public function __construct(Recipe $recipe)
    {
        parent::__construct($recipe, self::RELATIONS);
    }

    public function getLastPatientRecipe($patientId)
    {
        return $this->model->where('patient_id', $patientId)->latest()->first();
    }

    public function findOrFail(int $id)
    {
        return Recipe::findOrFail($id);
    }

    public function save(Recipe $recipe)
    {
        return $recipe->save();
    }
}
