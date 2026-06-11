<?php

namespace App\Http\Requests\Planilla;

use Illuminate\Foundation\Http\FormRequest;

class StoreRevisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comentario' => ['sometimes', 'string'],
            'audio'      => ['sometimes', 'string'],
            'estado'     => ['required', 'string', 'in:revisado,aprobado,rechazado'],
        ];
    }

    public function messages(): array
    {
        return [
            'estado.required' => 'El estado es obligatorio.',
            'estado.in'       => 'El estado debe ser revisado, aprobado o rechazado.',
        ];
    }
}
