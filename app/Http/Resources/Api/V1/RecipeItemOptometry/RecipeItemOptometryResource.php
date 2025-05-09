<?php

namespace App\Http\Resources\Api\V1\RecipeItemOptometry;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\RecipeItem\RecipeItemResource;

class RecipeItemOptometryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'recipe_item_optometry',
            'id' => $this->id,
            'attributes' => [
                'recipe_id' => $this->recipe_id,
                'details' => $this->details,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at
            ],
            'links' => [
                'self' => route('recipe-item-optometries.show', $this->id)
            ],
            'relationships' => [
                'recipe_id' => [
                    'data' => [
                        'type' => 'recipe_items',
                        'id' => $this->recipe_id,
                    ],
                ],
            ],
            'include' => [
                new RecipeItemResource($this->whenLoaded('recipeItem')),
            ],
        ];
    }
}
