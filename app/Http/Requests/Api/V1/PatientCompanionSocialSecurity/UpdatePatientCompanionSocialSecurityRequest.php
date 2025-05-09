<?php

namespace App\Http\Requests\Api\V1\PatientCompanionSocialSecurity;

use App\Enum\EthnicityEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientCompanionSocialSecurityRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $patientId = $this->route('id'); // Obtiene el ID del paciente desde la ruta
        return [
            // Validaciones para Companion
            'companions' => 'array|nullable',
            'companions.*.document_type' => 'nullable',
            'companions.*.document_number' => [
                'nullable',
                'string'
            ],
            'companions.*.first_name' => 'nullable|string|max:50',
            'companions.*.last_name' => 'nullable|string|max:50',
            'companions.*.mobile' => 'nullable|string|max:20',
            'companions.*.email' => 'email|max:100',
            'companions.*.is_active' => 'boolean',
            'social_security.type_scheme' => 'nullable|string',
            'social_security.affiliate_type' => 'nullable|string',
            'social_security.category' => 'nullable|string',
            'social_security.entity_id' => 'nullable|exists:entities,id',
            'social_security.arl' => 'nullable|string|max:255',
            'social_security.afp' => 'nullable|string|max:255',
            'social_security.insurer' => 'nullable|string|max:255',

            // Validaciones para el paciente
            'patient.document_type' => 'sometimes',
            'patient.document_number' => 'sometimes|string|unique:patients,document_number,' . $this->route('id'),
            'patient.first_name' => 'nullable|string|max:50',
            'patient.middle_name' => 'nullable|string|max:50',
            'patient.last_name' => 'nullable|string|max:50',
            'patient.second_last_name' => 'nullable|string|max:50',
            'patient.gender' => 'nullable|in:MALE,FEMALE,OTHER,INDETERMINATE',
            'patient.date_of_birth' => 'nullable|date|before_or_equal:today',
            'patient.whatsapp' => 'nullable',
            'patient.email' => 'nullable',
            'patient.country_id' => 'nullable',
            'patient.department_id' => 'nullable',
            'patient.city_id' => 'nullable',
            'patient.address' => 'nullable|string|max:255',
            'patient.civil_status' => 'nullable|string|max:50',
            'patient.ethnicity' => ['nullable', 'string', 'max:50'],
            'patient.nationality' => 'nullable|string|max:100',
            'patient.is_active' => 'nullable|boolean',
        ];
    }


    public function messages()
    {
        return [
            // Mensajes para Companion
            'companions.required' => 'Los acompañantes son obligatorios.',
            'companions.array' => 'Los acompañantes deben ser un array.',
            'companions.*.document_type.required' => 'El tipo de documento del acompañante es obligatorio.',
            'companions.*.document_number.required' => 'El número de documento del acompañante es obligatorio.',
            'companions.*.document_number.integer' => 'El número de documento del acompañante debe ser un número entero.',
            'companions.*.document_number.unique' => 'El número de documento del acompañante ya existe en la base de datos.',
            'companions.*.first_name.required' => 'El nombre del acompañante es obligatorio.',
            'companions.*.first_name.string' => 'El nombre del acompañante debe ser una cadena de texto.',
            'companions.*.first_name.max' => 'El nombre del acompañante no debe exceder los 50 caracteres.',
            'companions.*.last_name.required' => 'El apellido del acompañante es obligatorio.',
            'companions.*.last_name.string' => 'El apellido del acompañante debe ser una cadena de texto.',
            'companions.*.last_name.max' => 'El apellido del acompañante no debe exceder los 50 caracteres.',
            'companions.*.mobile.required' => 'El móvil del acompañante es obligatorio.',
            'companions.*.mobile.string' => 'El móvil del acompañante debe ser una cadena de texto.',
            'companions.*.mobile.max' => 'El móvil del acompañante no debe exceder los 20 caracteres.',
            'companions.*.email.required' => 'El email del acompañante es obligatorio.',
            'companions.*.email.email' => 'El email del acompañante debe ser una dirección de correo válida.',
            'companions.*.email.max' => 'El email del acompañante no debe exceder los 100 caracteres.',
            'companions.*.email.unique' => 'El email del acompañante ya existe en la base de datos.',
            'companions.*.is_active.boolean' => 'El estado de actividad del acompañante debe ser verdadero (1) o falso (0).',

            // Mensajes para SocialSecurity
            'social_security.type_scheme.string' => 'El esquema de tipo debe ser una cadena de texto.',
            'social_security.affiliate_type.string' => 'El tipo de afiliado debe ser una cadena de texto.',
            'social_security.category.string' => 'La categoría debe ser una cadena de texto.',
            'social_security.eps.string' => 'El EPS debe ser una cadena de texto.',
            'social_security.eps.max' => 'El EPS no debe exceder los 255 caracteres.',
            'social_security.arl.string' => 'La ARL debe ser una cadena de texto.',
            'social_security.arl.max' => 'La ARL no debe exceder los 255 caracteres.',
            'social_security.afp.string' => 'La AFP debe ser una cadena de texto.',
            'social_security.afp.max' => 'La AFP no debe exceder los 255 caracteres.',
            'social_security.insurer.string' => 'La aseguradora debe ser una cadena de texto.',
            'social_security.insurer.max' => 'La aseguradora no debe exceder los 255 caracteres.',

            // Mensajes para Patient
            'patient.document_type.required' => 'El tipo de documento del paciente es obligatorio.',
            'patient.document_type.in' => 'El tipo de documento del paciente debe ser CC, CE o TI.',
            'patient.document_number.required' => 'El número de documento del paciente es obligatorio.',
            'patient.document_number.integer' => 'El número de documento del paciente debe ser un número entero.',
            'patient.document_number.unique' => 'El número de documento del paciente ya existe en la base de datos.',
            'patient.first_name.required' => 'El nombre del paciente es obligatorio.',
            'patient.first_name.string' => 'El nombre del paciente debe ser una cadena de texto.',
            'patient.first_name.max' => 'El nombre del paciente no debe exceder los 50 caracteres.',
            'patient.middle_name.string' => 'El segundo nombre del paciente debe ser una cadena de texto.',
            'patient.middle_name.max' => 'El segundo nombre del paciente no debe exceder los 50 caracteres.',
            'patient.last_name.required' => 'El apellido del paciente es obligatorio.',
            'patient.last_name.string' => 'El apellido del paciente debe ser una cadena de texto.',
            'patient.last_name.max' => 'El apellido del paciente no debe exceder los 50 caracteres.',
            'patient.second_last_name.string' => 'El segundo apellido del paciente debe ser una cadena de texto.',
            'patient.second_last_name.max' => 'El segundo apellido del paciente no debe exceder los 50 caracteres.',
            'patient.gender.required' => 'El género del paciente es obligatorio.',
            'patient.gender.in' => 'El género del paciente debe ser MALE, FEMALE, OTHER o INDETERMINATE.',
            'patient.date_of_birth.required' => 'La fecha de nacimiento del paciente es obligatoria.',
            'patient.date_of_birth.date' => 'La fecha de nacimiento del paciente debe ser una fecha válida.',
            'patient.date_of_birth.before_or_equal' => 'La fecha de nacimiento del paciente debe ser igual o anterior a hoy.',
            'patient.whatsapp.required' => 'El WhatsApp del paciente es obligatorio.',
            'patient.email.unique' => 'El email del paciente ya existe en la base de datos.',
            'patient.country_id.required' => 'El país del paciente es obligatorio.',
            'patient.country_id.exists' => 'El país del paciente debe existir en la base de datos.',
            'patient.department_id.required' => 'El departamento del paciente es obligatorio.',
            'patient.department_id.exists' => 'El departamento del paciente debe existir en la base de datos.',
            'patient.city_id.required' => 'La ciudad del paciente es obligatoria.',
            'patient.city_id.exists' => 'La ciudad del paciente debe existir en la base de datos.',
            'patient.address.string' => 'La dirección del paciente debe ser una cadena de texto.',
            'patient.address.max' => 'La dirección del paciente no debe exceder los 255 caracteres.',
            'patient.civil_status.string' => 'El estado civil del paciente debe ser una cadena de texto.',
            'patient.civil_status.max' => 'El estado civil del paciente no debe exceder los 50 caracteres.',
            'patient.ethnicity.string' => 'La etnia del paciente debe ser una cadena de texto.',
            'patient.ethnicity.max' => 'La etnia del paciente no debe exceder los 50 caracteres.',
            'patient.ethnicity.in' => 'La etnia del paciente debe ser un valor válido.',
            'patient.nationality.string' => 'La nacionalidad del paciente debe ser una cadena de texto.',
            'patient.nationality.max' => 'La nacionalidad del paciente no debe exceder los 100 caracteres.',
            'patient.is_active.boolean' => 'El estado de actividad del paciente debe ser verdadero (1) o falso (0).',
        ];
    }
}
