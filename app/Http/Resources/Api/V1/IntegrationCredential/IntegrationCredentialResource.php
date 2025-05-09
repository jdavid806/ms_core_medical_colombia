<?php

namespace App\Http\Resources\Api\V1\IntegrationCredential;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\Integration\IntegrationResource;

class IntegrationCredentialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'integration_credentials',
            'id' => (string) $this->id,
            'attributes' => [
                'integration_id' => $this->integration_id,
                'key' => $this->key,
                'value' => $this->value,
                'is_sensitive' => $this->is_sensitive,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'integration' => [
                    'data' => [
                        'type' => 'integrations',
                        'id' => (string) $this->integration_id,
                    ],
                ],
            ],
            'links' => [
                'self' => route('integration-credentials.show', $this->id),
            ],
            'meta' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'included' => [
                'integration' => new IntegrationResource($this->whenLoaded('integration')),
            ],
        ];
    }
}
