<?php

namespace App\Http\Requests\Materia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMateriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $materiaId = $this->route('materia') ? $this->route('materia')->id : null;

        return [
            'nombre' => 'sometimes|required|string|max:255|unique:materias,nombre,' . $materiaId,
            'area_id' => 'nullable|integer|exists:areas,id',
            'primer_ciclo' => 'boolean',
            'segundo_ciclo' => 'boolean',
            'tercer_ciclo' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la materia no puede quedar vacío.',
            'nombre.unique' => 'Ese nombre de materia ya está en uso por otro registro.',
        ];
    }
}
