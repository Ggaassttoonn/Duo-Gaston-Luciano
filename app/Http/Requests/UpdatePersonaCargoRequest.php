<?php

namespace App\Http\Requests;

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
           
            'personas_id' => 'sometimes|required|integer|exists:personas,id',
            'cargos_id' => 'sometimes|required|integer|exists:cargos,id',
            'sit_revista_id' => 'sometimes|required|integer|exists:sit_revistas,id',
        ];
    }
}