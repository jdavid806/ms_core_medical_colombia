<?php

namespace App\Http\Resources\Api\V1\Integration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'status' => $this->status,
                'url' => $this->url,
                'auth_type' => $this->auth_type,
                'auth_config' => $this->auth_config,
            ],
            'relationships' => [
                'credentials' => [
                    'data' => $this->whenLoaded('credentials', function () {
                        return $this->credentials->map(function ($credential) {
                            return [
                                'id' => $credential->id,
                                'type' => 'integration_credentials',
                                'attributes' => [
                                    'name' => $credential->name,
                                    'value' => $credential->value,
                                    'type' => $credential->type,
                                    'status' => $credential->status,
                                ],
                            ];
                        });
                    }),
                ],
            ],
            'meta' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => route('integrations.show', ['integration' => $this->id]),
            ],
            'included' => [
                // Include related resources if needed
            ],
        ];
    }
}
