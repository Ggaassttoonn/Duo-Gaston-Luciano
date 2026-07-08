<?php

namespace App\Http\Requests\PersonaCargo;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaCargoRequest extends FormRequest
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
            'persona_id' => [
                'required',
                'integer',
                'exists:personas,id' 
            ],
            'cargo_id' => [
                'required',
                'integer',
                'exists:cargos,id' 
            ],
            'sit_revista_id' => [
                'required',
                'integer',
                'exists:sit_revista,id' 
            ],
        ];
    }

    /**
   
     */
    public function messages(): array
    {
        return [
            'persona_id.exists' => 'La persona seleccionada no es válida.',
            'cargo_id.exists' => 'El cargo seleccionado no existe.',
            'sit_revista_id.exists' => 'La situación de revista no es válida.',
        ];
    }
}