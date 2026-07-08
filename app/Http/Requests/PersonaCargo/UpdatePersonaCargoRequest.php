<?php

namespace App\Http\Requests\PersonaCargo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaCargoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           
            'persona_id' => 'sometimes|required|integer|exists:personas,id',
            'cargo_id' => 'sometimes|required|integer|exists:cargos,id',
            'sit_revista_id' => 'sometimes|required|integer|exists:sit_revista,id',
        ];
    }
}