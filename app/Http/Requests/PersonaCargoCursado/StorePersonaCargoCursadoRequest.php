<?php

namespace App\Http\Requests;

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
            'cursados_id' => [
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
            'cursados_id.exists' => 'El cursado seleccionado no existe.',
        ];
    }
}