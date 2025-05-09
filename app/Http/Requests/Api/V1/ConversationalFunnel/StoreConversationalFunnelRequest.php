<?php

namespace App\Http\Requests\Api\V1\ConversationalFunnel;

use Illuminate\Foundation\Http\FormRequest;

class StoreConversationalFunnelRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'patient_id.required' => 'El paciente es requerido.',
            'channel.required' => 'El canal es requerido.',
            'current_agent_id.required' => 'El agente actual es requerido.',
            'status.required' => 'El estado es requerido.',
            'last_message.required' => 'El último mensaje es requerido.',
            'last_event.required' => 'El último evento es requerido.',
        ];
    }

    /* public function attributes()
    {
        return [
            'patient_id' => 'Paciente',
            'channel' => 'Canal',
            'current_agent_id' => 'Agente actual',
            'status' => 'Estado',
            'last_message' => 'Último mensaje',
            'last_event' => 'Último evento',
        ];
    } */

}
