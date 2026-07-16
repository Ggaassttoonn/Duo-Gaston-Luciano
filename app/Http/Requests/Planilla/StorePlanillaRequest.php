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
            'titulo'     => ['required_without:title', 'nullable', 'string', 'max:255'],
            'contenido'  => ['required_without:content', 'nullable', 'string'],
            'title'      => ['required_without:titulo', 'nullable', 'string', 'max:255'],
            'content'    => ['required_without:contenido', 'nullable', 'string'],
            'directores' => ['sometimes', 'array'],
            'directores.*' => ['integer', 'exists:users,id'],
        ];
    }
}
