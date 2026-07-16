<?php

namespace App\Http\Requests\EstadoDiaria;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadoDiariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado'                  => 'sometimes|required|string|max:100',
            'fecha'                   => 'sometimes|required|date',
            'planificacion_diaria_id' => 'sometimes|required|exists:planificacion_diaria,id',
        ];
    }
}