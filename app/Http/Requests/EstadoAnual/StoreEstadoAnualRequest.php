<?php

namespace App\Http\Requests\EstadoAnual;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
        
            'estado'                 => 'required|string|max:100', 
            'fecha'                  => 'required|date',
            'planificacion_anual_id' => 'required|exists:planificaciones_anuales,id',
        ];
    }
}