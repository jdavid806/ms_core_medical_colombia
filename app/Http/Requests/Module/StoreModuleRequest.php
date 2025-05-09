<?php

namespace App\Http\Requests\Module;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enum\TicketReason;

class StoreModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajustar lógica de autorización según necesidad
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'allowed_reasons' => [
                'required',
                'array',
                Rule::in(TicketReason::values())
            ],
            'is_active' => 'sometimes|boolean'
        ];
    }

    // app/Http/Requests/Module/StoreModuleRequest.php

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del módulo es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',

            'branch_id.required' => 'La sucursal es obligatoria.',
            'branch_id.exists' => 'La sucursal seleccionada no existe.',

            'allowed_reasons.required' => 'Debe seleccionar al menos un motivo válido.',
            'allowed_reasons.array' => 'Los motivos deben ser una lista de opciones.',
            'allowed_reasons.in' => 'Los motivos permitidos contienen valores inválidos.',

            'is_active.boolean' => 'El estado activo debe ser verdadero o falso.'
        ];
    }
}
