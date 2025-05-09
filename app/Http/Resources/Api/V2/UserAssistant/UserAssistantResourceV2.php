<?php

namespace App\Http\Resources\Api\V2\UserAssistant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssistantResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user_assistant',
            'id' => $this->id,
            'attributes' => [
                'supervisor_user_id' => $this->supervisor_user_id,
                'assistant_user_id' => $this->assistant_user_id,
            ],
            'relationships' => [
                'supervisor' => [
                    'data' => [
                        'type' => 'users',
                        'id' => $this->supervisor_user_id,
                        'attributes' => [
                            'name' => $this->supervisor->first_name . ' ' . $this->supervisor->last_name,
                            'email' => $this->supervisor->email,
                        ],
                    ],
                ],
                'assistant' => [
                    'data' => [
                        'type' => 'users',
                        'id' => $this->assistant_user_id,
                        'attributes' => [
                            'name' => $this->assistant->first_name . ' ' . $this->assistant->last_name,
                            'email' => $this->assistant->email,
                        ],
                    ],
                ],
            ],
            'links' => [
                'self' => route('user-assistants.show', $this->id),
            ],
        ];
    }
}
