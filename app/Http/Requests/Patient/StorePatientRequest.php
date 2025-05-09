<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'document_type' => 'required',
            'document_number' => 'required|string|unique:patients',
            /* 'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'second_last_name' => 'nullable|string|max:50',
            'gender' => 'required|in:MALE,FEMALE,OTHER,INDETERMINATE',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'whatsapp' => 'required',
            'email' => 'nullable|email',
            'country_id' => 'required|exists:countries,id',
            'department_id' => 'required|exists:departments,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:255',
            'eps' => 'nullable|string|max:255',
            'afp' => 'nullable|string|max:255',
            'arl' => 'nullable|string|max:255',
            'affiliate_type' => 'nullable|string|max:50',
            'branch_office' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'civil_status' => 'nullable|string|max:50',
            'ethnicity' => 'nullable|string|max:50',
            'social_security_id' => 'required|exists:social_securities,id',
            'blood_type' => 'required|string', */
        ];
    }

    public function messages()
    {
        return [
            'document_number.unique' => 'El documento ya ha sido registrado.',
            'email.unique' => 'El correo ya ha sido registrado.',
            'whatsapp.unique' => 'El whatsapp ya ha sido registrado.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            'is_active.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
            'date_of_birth.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual.',
            ''
        ];
    }
}
