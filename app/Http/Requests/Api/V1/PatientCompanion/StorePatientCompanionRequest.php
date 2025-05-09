<?php

namespace App\Http\Requests\Api\V1\PatientCompanion;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientCompanionRequest extends FormRequest
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
            'companions' => 'required|array',
            'companions.*.companion_id' => 'required|exists:companions,id',
            'companions.*.relationship_id' => 'required|exists:relationships,id'
        ];
    }
}
