<?php

namespace App\Http\Requests\Planilla;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanillaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $input = $this->all();

        if (!isset($input['titulo']) && isset($input['title'])) {
            $input['titulo'] = (string) $input['title'];
        }
        if (!isset($input['contenido']) && isset($input['content'])) {
            $input['contenido'] = (string) $input['content'];
        }

        $this->replace($input);
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
