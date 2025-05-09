<?php

namespace App\Http\Resources\Api\V1\Agent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\AiResponse\AiResponseResource;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'agent',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
            ],
            'relationships' => [
                'ai-response' => [
                    'data' => [
                        'type' => 'ai-response',
                        'id' => $this->ai_response_id,
                    ],
                ],
            ],
            'include' => [
                new AiResponseResource($this->whenLoaded('aiResponse')),
            ],
            'links' => [
                'self' => route('agents.show', $this->id),
            ],
        ];
    }
}
