<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\TicketReason;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'reason' => [
                'required',
                Rule::in(TicketReason::values())
            ],
            'priority' => [
                'required',
                Rule::in(TicketPriority::values())
            ],
            'status' => [
                'sometimes',
                Rule::in(TicketStatus::values())
            ],
            'branch_id' => 'required|exists:branches,id'
        ];
    }

    // Valores por defecto para campos opcionales
    public function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status ?? TicketStatus::PENDING->value
        ]);
    }

    // app/Http/Requests/Ticket/StoreTicketRequest.php

    public function messages(): array
    {
        return [
            'patient_name.required' => 'El nombre del paciente es obligatorio.',
            'patient_name.string' => 'El nombre del paciente debe ser un texto válido.',
            'patient_name.max' => 'El nombre del paciente no debe exceder los 255 caracteres.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.string' => 'El teléfono debe ser un texto válido.',
            'phone.max' => 'El teléfono no debe exceder los 20 caracteres.',

            'email.email' => 'El correo electrónico no es válido.',
            'email.max' => 'El correo no debe exceder los 255 caracteres.',

            'reason.required' => 'La razón del ticket es obligatoria.',
            'reason.in' => 'La razón del ticket seleccionada es inválida.',

            'priority.required' => 'La prioridad es obligatoria.',
            'priority.in' => 'La prioridad seleccionada es inválida.',

            'status.in' => 'El estado seleccionado es inválido.',

            'branch_id.required' => 'La sucursal es obligatoria.',
            'branch_id.exists' => 'La sucursal seleccionada no existe.',
        ];
    }
}
