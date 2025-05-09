<?php

namespace App\Http\Requests\Api\V1\Prescription;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
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
            'medicines' => 'required|array|min:1',
            'medicines.*.product_service_id' => 'required|integer',
            'medicines.*.dosis' => 'required|string',
            'medicines.*.via' => 'required|string',
            'medicines.*.quantity' => 'required|integer|min:1'
        ];
    }
}
