<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
        
            'area' => 'required|string|max:255|unique:areas,area',
            
           
            'tipo' => 'required|string|max:1000', 
        ];
    }

    public function messages(): array
    {
        return [
            'area.required' => 'El nombre del área es obligatorio.',
            'area.unique' => 'Esta área ya se encuentra registrada.',
            'tipo.required' => 'El tipo de área es obligatorio.',
        ];
    }
}