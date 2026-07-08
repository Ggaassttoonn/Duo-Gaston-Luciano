<?php

namespace App\Http\Requests\PersonaCargoCursado;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaCargoCursadoRequest extends FormRequest
{
    /**
     * 
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 
     */
    public function rules(): array
    {
        return [
            'persona_cargos_id' => [
                'required',
                'integer',
                'exists:persona_cargos,id', 
            ],
            'cursado_id' => [
                'required',
                'integer',
                'exists:cursados,id', 
            ],
        ];
    }

    /**
     * 
     */
    public function messages(): array
    {
        return [
            'persona_cargos_id.exists' => 'El cargo de la persona seleccionado no es válido.',
            'cursado_id.exists' => 'El cursado seleccionado no existe.',
        ];
    }
}