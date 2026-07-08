<?php

namespace App\Http\Requests\Planilla;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanillaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'     => ['required', 'string', 'max:255'],
            'contenido'  => ['required', 'string'],
            'directores' => ['sometimes', 'array'],
            'directores.*' => ['integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'     => 'El título es obligatorio.',
            'contenido.required'  => 'El contenido es obligatorio.',
        ];
    }
}
