<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        $cargoId = $this->route('cargo') ? $this->route('cargo')->id : null;

        return [
         
            'cargo' => 'sometimes|required|string|max:255|unique:cargos,cargo,' . $cargoId,
        ];
    }

    public function messages(): array
    {
        return [
            'cargo.required' => 'El nombre del cargo no puede quedar vacío.',
            'cargo.unique' => 'Este cargo ya está asignado a otro registro.',
        ];
    }
}