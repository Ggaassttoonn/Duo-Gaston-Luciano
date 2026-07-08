<?php

namespace App\Http\Requests\Materia;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:materias,nombre',
            'area_id' => 'nullable|integer|exists:areas,id',
            'primer_ciclo' => 'boolean',
            'segundo_ciclo' => 'boolean',
            'tercer_ciclo' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'nombre.unique' => 'Esta materia ya se encuentra registrada.',
        ];
    }
}
