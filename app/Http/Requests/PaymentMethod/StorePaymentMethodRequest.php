<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'method' => 'required',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'method.required' => 'El campo método es requerido',
            'method.string' => 'El campo método debe ser una cadena de texto',
            'method.unique' => 'El método de pago ya
            existe',
            'description.string' => 'El campo descripción debe ser una cadena de texto',
        ];
    }
}
