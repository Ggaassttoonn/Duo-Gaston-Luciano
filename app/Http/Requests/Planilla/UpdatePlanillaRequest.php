<?php

namespace App\Http\Requests\Planilla;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanillaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'    => ['sometimes', 'string', 'max:255'],
            'contenido' => ['sometimes', 'string'],
            'estado'    => ['sometimes', 'string', 'in:borrador,pendiente,revisado,aprobado,rechazado'],
            'directores' => ['sometimes', 'array'],
            'directores.*' => ['integer', 'exists:users,id'],
        ];
    }
}
