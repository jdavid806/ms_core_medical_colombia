<?php

namespace App\Http\Requests\Api\V2\SocialSecurity;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialSecurityRequestV2 extends FormRequest
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
            'type_scheme' => 'required|string',
            'affiliate_type' => 'required|string',
            'category' => 'required|string',
            'entity_id' => 'required|integer|exists:entities,id',
            'arl' => 'nullable|string',
            'afp' => 'nullable|string',
            'insurer' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'type_scheme.required' => 'El campo es requerido',
            'affiliate_type.required' => 'El campo es requerido',
            'category.required' => 'El campo es requerido',
            'entity_id.required' => 'El campo es requerido',
            'entity_id.exists' => 'La entidad no existe',
        ];
    }
}
