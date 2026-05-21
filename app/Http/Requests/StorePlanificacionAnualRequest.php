<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanificacionAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'fecha_presentacion'       => ['required', 'date'],
            'aprendizajes_esperados'   => ['required', 'string'],
            'saberes'                  => ['required', 'string'],
            'criterios'                => ['required', 'string'],
            'bibliografia'             => ['nullable', 'string'],
            'diagnostico'              => ['nullable', 'string'],
            'areas_id'                 => ['required', 'exists:areas,id'],
            'persona_cargo_cursado_id' => ['required', 'exists:persona_cargo_cursado,id'],
            'tipo_planificacion'       => ['required', 'string'],
        ];
    }
}
