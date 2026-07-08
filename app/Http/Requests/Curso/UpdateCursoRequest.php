<?php

namespace App\Http\Requests\Curso;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ciclo'   => 'sometimes|required|string|max:50',
            'grado'   => 'sometimes|required|string|max:50',
            'seccion' => 'sometimes|required|string|max:10',
            'turno'   => 'sometimes|required|string|max:30',
        ];
    }
}