<?php

namespace App\Http\Requests\SitRevista;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSitRevistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        $sitRevistaId = $this->route('sitRevista')?->id;

        return [
            
            'revista' => 'sometimes|string|max:255|unique:sit_revista,revista,' . $sitRevistaId,
        ];
    }

    public function messages(): array
    {
        return [
            'revista.unique' => 'Esta situación de revista ya se encuentra registrada.',
        ];
    }
}