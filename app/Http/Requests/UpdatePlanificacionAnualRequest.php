<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanificacionAnualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
       
        return [
            'fecha_presentacion'       => ['sometimes', 'date'],
            'aprendizajes_esperados'   => ['sometimes', 'string'],
            'saberes'                  => ['sometimes', 'string'],
            'criterios'                => ['sometimes', 'string'],
            'bibliografia'             => ['nullable', 'string'],
            'diagnostico'              => ['nullable', 'string'],
            'areas_id'                 => ['sometimes', 'exists:areas,id'],
            'persona_cargo_cursado_id' => ['sometimes', 'exists:persona_cargo_cursado,id'],
            'tipo_planificacion'       => ['sometimes', 'string'],
        ];
    }
}