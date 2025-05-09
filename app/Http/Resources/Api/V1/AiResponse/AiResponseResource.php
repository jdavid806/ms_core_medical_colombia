<?php

namespace App\Http\Resources\Api\V1\AiResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'ai-response',
            'id' => $this->id,
            'attributes' => [
                'responsable_type' => $this->responsable_type,
                'responsable_id' => $this->responsable_id,
                'agent_id' => $this->agent_id,
                'response' => $this->response,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at,
            ],
            'include' => [
                'responsable' => [
                    'type' => $this->responsable_type,
                    'id' => $this->responsable_id,
                    'attributes' => [
                        'name' => $this->responsable->name
                    ]
                ],
            ],
            'links' => [
                'self' => route('ai-responses.show', $this->id),
            ],
        ];
    }
}
