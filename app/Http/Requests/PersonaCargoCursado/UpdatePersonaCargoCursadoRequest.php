<?php

namespace App\Http\Requests\PersonaCargoCursado;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaCargoCursadoRequest extends FormRequest
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
            'persona_cargos_id' => 'sometimes|required|integer|exists:persona_cargos,id',
            'cursado_id'       => 'sometimes|required|integer|exists:cursados,id',
        ];
    }
}