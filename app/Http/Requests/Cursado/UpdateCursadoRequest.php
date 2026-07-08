<?php

namespace App\Http\Requests\Cursado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCursadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            // Usamos 'sometimes' para permitir actualizaciones parciales (si un campo no viene, no se valida)
            'anio_lectivo' => 'sometimes|required|integer|min:2020|max:2100',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_fin'    => 'sometimes|required|date|after_or_equal:fecha_inicio',
            'curso_id'    => 'sometimes|required|exists:cursos,id',
        ];
    }
}