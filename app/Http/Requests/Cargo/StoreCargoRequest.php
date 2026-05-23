<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
           
            'cargo' => 'required|string|max:255|unique:cargos,cargo',
        ];
    }

    public function messages(): array
    {
        return [
            'cargo.required' => 'El nombre del cargo es obligatorio.',
            'cargo.unique' => 'Este cargo ya se encuentra registrado.',
        ];
    }
}
