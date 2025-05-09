<?php

namespace App\Http\Resources\Api\V1\Recipe;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /* return [
            'type' => 'recipes',
            'id' => $this->id,
            'attributes' => [
                'patient_id' => $this->patient_id,
                'user_id' => $this->user_id,
                'appointment_id' => $this->appointment_id,
                'is_active' => $this->is_active,
                'type' => $this->type,
                'description' => $this->description,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => route('recipes.show', $this->id),
            ],
            'relationships' => [
                'patient' => [
                    'data' => [
                        'type' => 'patients',
                        'id' => $this->patient_id,
                    ],
                ],
                'prescriber' => [
                    'data' => [
                        'type' => 'users',
                        'id' => $this->user_id,
                    ],
                ],
                'recipeItems' => [
                    'data' => $this->recipeItems->map(function ($recipeItem) {
                        return [
                            'type' => 'recipeItems',
                            'id' => $recipeItem->id,
                        ];
                    }),
                ],
            ],
        ]; */

        return parent::toArray($request);
    }
}
