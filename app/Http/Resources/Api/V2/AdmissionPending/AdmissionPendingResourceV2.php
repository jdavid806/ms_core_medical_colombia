<?php

namespace App\Http\Resources\Api\V2\AdmissionPending;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionPendingResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'admission_pending',
            'id' => $this->id,
            'attributes' => [
                'assigned_user_availability_id' => $this->use,
                'created_by_user_id' => $this->created_by_user_id,
                'patient_id' => $this->patient_id,
                'appointment_state_id' => $this->appointment_state_id,
                'appointment_time' => $this->appointment_time,
                'appointment_date' => $this->appointment_date,
                'attention_type' => $this->attention_type,
                'consultation_purpose' => $this->consultation_purpose,
                'consultation_type' => $this->consultation_type,
                'external_cause' => $this->external_cause,
                'is_active' => $this->is_active,
                'product_id' => $this->product_id,
            ],
            'relationships' => [
                'assigned_user_availability' => [
                    'data' => [
                        'type' => 'user_availabilities',
                        'id' => $this->assigned_user_availability_id,
                    ],
                ],
                'created_by_user' => [
                    'data' => [
                        'type' => 'users',
                        'id' => $this->created_by_user_id,
                    ],
                ],
                'patient' => [
                    'data' => [
                        'type' => 'patients',
                        'id' => $this->patient_id,
                    ],
                ],
                'appointment_state' => [
                    'data' => [
                        'type' => 'appointment_states',
                        'id' => $this->appointment_state_id,
                    ],
                ],
            ],
        ];
    }
}
