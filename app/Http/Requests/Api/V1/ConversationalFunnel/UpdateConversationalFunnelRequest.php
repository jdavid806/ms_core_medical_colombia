<?php

namespace App\Http\Requests\Api\V1\ConversationalFunnel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConversationalFunnelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'channel' => 'required|string',
            'current_agent_id' => 'required|exists:agents,id',
            'status' => 'required|string|in:ACTIVE, INACTIVE, ERROR, PENDING, FINISHED',
            'last_message' => 'nullable|string',
            'last_event' => 'nullable|date',
            'data_json' => 'nullable|string',
        ];
    }
}
