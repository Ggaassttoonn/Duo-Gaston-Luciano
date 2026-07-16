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
            'titulo'    => $this->titulo ?? $this->title ?? null,
            'contenido' => $this->contenido ?? $this->content ?? null,
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
