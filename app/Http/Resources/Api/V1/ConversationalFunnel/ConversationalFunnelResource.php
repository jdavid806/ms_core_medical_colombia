<?php

namespace App\Http\Resources\Api\V1\ConversationalFunnel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationalFunnelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'conversational_funnel',
            'id' => $this->id,
            'attributes' => [
                'patient_id' => $this->patient_id,
                'appointment_id' => $this->appointment_id,
                'channel' => $this->channel,
                'current_agent_id' => $this->current_agent_id,
                'status' => $this->status,
                'last_message' => $this->last_message,
                'last_event' => $this->last_event,
                'data_json' => $this->data_json,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at
            ],
            'links' => [
                'self' => route('conversational-funnels.show', $this->id)
            ],
            'relationships' => [
                'patient' => [
                    'data' => [
                        'type' => 'patients',
                        'id' => $this->patient_id
                    ]
                ],
                'appointment' => [
                    'data' => [
                        'type' => 'appointments',
                        'id' => $this->appointment_id
                    ]
                ],
                'current_agent' => [
                    'data' => [
                        'type' => 'agents',
                        'id' => $this->current_agent_id
                    ]
                ],
            ]
        ];
    }
}
