<?php

namespace App\Http\Resources\Api\V1\IntegrationUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'integration_users',
            'id' => $this->id,
            'attributes' => [
                'user_id' => $this->user_id,
                'integration_id' => $this->integration_id,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at,
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'type' => 'users',
                        'id' => $this->user_id,
                    ],
                ],
                'integration' => [
                    'data' => [
                        'type' => 'integrations',
                        'id' => $this->integration_id,
                    ],
                ],
            ],
            'links' => [
                'self' => route('integration-users.show', $this->id),
            ],
            'meta' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
