<?php

namespace App\Http\Requests;

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
            'cursados_id'       => 'sometimes|required|integer|exists:cursados,id',
        ];
    }
}