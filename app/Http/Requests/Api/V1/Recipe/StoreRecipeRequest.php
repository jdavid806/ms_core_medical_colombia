<?php

namespace App\Http\Requests\Api\V1\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'patient_id' => 'required|integer',
            'user_id' => 'required|integer',
            'is_active' => 'sometimes|boolean',
            'type' => 'required|in:general,optometry',

            // Validación condicional para "general"
            'medicines' => 'required_if:type,general|array|min:1',
            'medicines.*.medication' => 'required_if:type,general|string',
            'medicines.*.concentration' => 'required_if:type,general|string',
            'medicines.*.frequency' => 'required_if:type,general|string',
            'medicines.*.duration' => 'required_if:type,general|integer|min:1',
            'medicines.*.medication_type' => 'required_if:type,general|string',
            'medicines.*.take_every_hours' => 'required_if:type,general|integer|min:1',
            'medicines.*.quantity' => 'required_if:type,general|integer|min:1',
            'medicines.*.observations' => 'nullable|string',

            // Validación para "optometry"
            'optometry' => 'required_if:type,optometry|array',
        ];
    }


    public function messages()
    {
        return [
            'type.required' => 'El campo type es obligatorio.',
            'type.in' => 'El campo type debe ser "general" o "optometry".',
        ];
    }
}
