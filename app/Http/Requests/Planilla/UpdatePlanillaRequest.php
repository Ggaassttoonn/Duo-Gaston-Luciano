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
            'titulo'    => ['sometimes', 'nullable', 'string', 'max:255'],
            'contenido' => ['sometimes', 'nullable', 'string'],
            'title'     => ['sometimes', 'nullable', 'string', 'max:255'],
            'content'   => ['sometimes', 'nullable', 'string'],
            'estado'    => ['sometimes', 'string', 'max:50'],
            'directores' => ['sometimes', 'array'],
            'directores.*' => ['integer', 'exists:users,id'],
        ];
    }
}
