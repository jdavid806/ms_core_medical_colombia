<?php

namespace App\Http\Requests\Api\V1\CopaymentRule;

use Illuminate\Foundation\Http\FormRequest;

class StoreCopaymentRuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    // StoreCopaymentRuleRequest
    public function rules(): array
    {
        return [
            'rules' => ['required', 'array'],
            'rules.*.attention_type' => ['required', 'string', 'in:consultation,procedure'],
            'rules.*.type_scheme' => ['required', 'string', 'in:contributory,subsidiary'],
            'rules.*.category' => ['required_if:rules.*.type_scheme,Contributory', 'nullable', 'string'],
            'rules.*.type' => ['required', 'string', 'in:fixed,percentage'],
            'rules.*.level' => ['required_if:rules.*.type_scheme,Subsidiary', 'nullable', 'string'],
            'rules.*.fixed_amount' => ['required_if:rules.*.type,fixed', 'numeric'], // <-- Cambio aquí
            'rules.*.percentage' => ['required_if:rules.*.type,percentage', 'numeric', 'min:0', 'max:100'], // <-- Y aquí
        ];
    }
}
