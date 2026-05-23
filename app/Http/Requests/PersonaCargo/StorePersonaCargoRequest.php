<?php

namespace App\Http\Requests;

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
            'personas_id' => [
                'required',
                'integer',
                'exists:personas,id' 
            ],
            'cargos_id' => [
                'required',
                'integer',
                'exists:cargos,id' 
            ],
            'sit_revista_id' => [
                'required',
                'integer',
                'exists:sit_revistas,id' 
            ],
        ];
    }

    /**
   
     */
    public function messages(): array
    {
        return [
            'personas_id.exists' => 'La persona seleccionada no es válida.',
            'cargos_id.exists' => 'El cargo seleccionado no existe.',
            'sit_revista_id.exists' => 'La situación de revista seleccionada no es válida.',
        ];
    }
}