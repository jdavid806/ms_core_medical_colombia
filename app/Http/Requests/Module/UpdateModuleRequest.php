<?php

namespace App\Http\Requests\Module;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enum\TicketReason;

class UpdateModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'branch_id' => 'sometimes|exists:branches,id',
            'allowed_reasons' => [
                'sometimes',
                'array',
                Rule::in(TicketReason::values())
            ],
            'is_active' => 'sometimes|boolean'
        ];
    }

    // app/Http/Requests/Module/UpdateModuleRequest.php

    public function messages(): array
    {
        return [
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',

            'branch_id.exists' => 'La sucursal seleccionada no existe.',

            'allowed_reasons.array' => 'Los motivos deben ser una lista de opciones.',
            'allowed_reasons.in' => 'Los motivos permitidos contienen valores inválidos.',

            'is_active.boolean' => 'El estado activo debe ser verdadero o falso.'
        ];
    }
}
