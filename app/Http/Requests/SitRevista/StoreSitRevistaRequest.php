<?php

namespace App\Http\Requests\SitRevista;

use Illuminate\Foundation\Http\FormRequest;

class StoreSitRevistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'revista' => 'required|string|max:255|unique:sit_revista,revista',
        ];
    }

    /**
     * 
     */
    public function messages(): array
    {
        return [
            'revista.required' => 'El nombre de la situación de revista es obligatorio.',
            'revista.unique'   => 'Esta situación de revista ya se encuentra registrada.',
        ];
    }
}