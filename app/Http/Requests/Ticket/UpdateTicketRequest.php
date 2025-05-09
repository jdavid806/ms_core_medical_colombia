<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\TicketPriority;
use App\Enum\TicketReason;
use App\Enum\TicketStatus;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'email' => 'sometimes|nullable|email|max:255',
            'reason' => [
                'sometimes',
                Rule::in(TicketReason::values())
            ],
            'priority' => [
                'sometimes',
                Rule::in(TicketPriority::values())
            ],
            'status' => [
                'sometimes',
                Rule::in(TicketStatus::values())
            ],
            'branch_id' => 'sometimes|exists:branches,id',
            'module_id' => 'sometimes|exists:modules,id'
        ];
    }

    // app/Http/Requests/Ticket/UpdateTicketRequest.php

    public function messages(): array
    {
        return [
            'patient_name.string' => 'El nombre del paciente debe ser un texto válido.',
            'patient_name.max' => 'El nombre del paciente no debe exceder los 255 caracteres.',

            'phone.string' => 'El teléfono debe ser un texto válido.',
            'phone.max' => 'El teléfono no debe exceder los 20 caracteres.',

            'email.email' => 'El correo electrónico no es válido.',
            'email.max' => 'El correo no debe exceder los 255 caracteres.',

            'reason.in' => 'La razón del ticket seleccionada es inválida.',

            'priority.in' => 'La prioridad seleccionada es inválida.',

            'status.in' => 'El estado seleccionado es inválido.',

            'branch_id.exists' => 'La sucursal seleccionada no existe.',

            'module_id.exists' => 'El módulo seleccionada no existe.'
        ];
    }
}
