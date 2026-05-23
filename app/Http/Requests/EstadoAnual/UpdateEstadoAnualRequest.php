<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadoAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado'                 => 'sometimes|required|string|max:100',
            'fecha'                  => 'sometimes|required|date',
            'planificacion_anual_id' => 'sometimes|required|exists:planificaciones_anuales,id',
        ];
    }
}
