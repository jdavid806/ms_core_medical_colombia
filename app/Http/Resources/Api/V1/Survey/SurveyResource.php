<?php

namespace App\Http\Resources\Api\V1\Survey;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'survey',
            'id' => $this->id,
            'attributes' => [
                'appointment_id' => $this->appointment_id,
                'respuesta' => $this->respuesta,
                'status' => $this->status,
                'sent_at' => $this->sent_at ? $this->sent_at->toDateTimeString() : null,
            ],
            'relationships' => [
                'appointment' => [
                    'data' => [
                        'type' => 'appointments',
                        'id' => $this->appointment_id,
                    ],
                ],
            ],
            'links' => [
                'self' => route('surveys.show', ['survey' => $this->id]),
            ],
            'meta' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'included' => [
                // Include related resources if needed
                // 'appointment' => new AppointmentResource($this->whenLoaded('appointment')),
            ],
        ];
    }
}
