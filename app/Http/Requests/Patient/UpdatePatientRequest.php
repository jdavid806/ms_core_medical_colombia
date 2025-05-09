<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'document_type' => 'sometimes|required|in:CC,CE,TI',
            'document_number' => 'sometimes|required|string|max:20|unique:patients,document_number,' . $this->route('patient'),
            'first_name' => 'sometimes|required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'sometimes|required|string|max:50',
            'second_last_name' => 'nullable|string|max:50',
            'gender' => 'sometimes|required|in:MALE,FEMALE,OTHER,INDETERMINATE',
            'date_of_birth' => 'sometimes|required|date|before_or_equal:today',
            'address' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'is_donor' => 'sometimes|required|boolean',
            'blood_type' => 'nullable|in:O_POSITIVE,O_NEGATIVE,A_POSITIVE,A_NEGATIVE,B_POSITIVE,B_NEGATIVE,AB_POSITIVE,AB_NEGATIVE',
            'has_special_condition' => 'sometimes|required|boolean',
            'special_condition' => 'nullable|string',
            'has_allergies' => 'sometimes|required|boolean',
            'allergies' => 'nullable|string',
            'has_surgeries' => 'sometimes|required|boolean',
            'surgeries' => 'nullable|string',
            'has_medical_history' => 'sometimes|required|boolean',
            'medical_history' => 'nullable|string',
            'eps' => 'nullable|string|max:255',
            'afp' => 'nullable|string|max:255',
            'arl' => 'nullable|string|max:255',
            'affiliate_type' => 'nullable|string|max:50',
            'branch_office' => 'nullable|string|max:255',
            'minio_id' => 'nullable|string|max:255',
        ];
    }
}
