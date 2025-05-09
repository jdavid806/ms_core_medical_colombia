<?php

namespace App\Http\Requests\Api\V1\RecipeItemOptometry;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeItemOptometryRequest extends FormRequest
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
            'recipe_id' => ['required', 'exists:recipes,id'],
            'details' => ['required', 'array'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();        
        $data['details'] = json_encode($data['details']);
        return $data;
    }

    public function messages()
    {
        return [
            'recipe_id.required' => 'El campo recipe_id es requerido.',
            'recipe_id.exists' => 'El campo recipe_id no existe.',
            'details.required' => 'El campo "details" es requerido.',
            'details.array' => 'El campo "details" debe ser un array.',
        ];
    }
}
