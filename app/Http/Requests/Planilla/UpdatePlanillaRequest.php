<?php

namespace App\Http\Requests\Planilla;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanillaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'titulo'    => $this->input('titulo') ?? $this->input('title') ?? null,
            'contenido' => $this->input('contenido') ?? $this->input('content') ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo'    => ['sometimes', 'string', 'max:255'],
            'contenido' => ['sometimes', 'string'],
            'estado'    => ['sometimes', 'string', 'max:50'],
            'directores' => ['sometimes', 'array'],
            'directores.*' => ['integer', 'exists:users,id'],
        ];
    }
}
