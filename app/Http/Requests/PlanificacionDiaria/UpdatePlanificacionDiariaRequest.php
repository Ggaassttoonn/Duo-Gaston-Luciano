<?php

namespace App\Http\Requests\PlanificacionDiaria;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanificacionDiariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_estimada'           => 'sometimes|date',
            'fecha_desarrollada'       => 'nullable|date',
            'fecha_presentacion'       => 'sometimes|date',
            'contenidos_especificos'   => 'sometimes|string',
            'actividades'              => 'sometimes|string',
            'tareas'                   => 'nullable|string',
            'persona_cargo_cursado_id' => 'sometimes|exists:persona_cargo_cursados,id',
            'tipo_planificacion'       => 'sometimes|string|max:255',
        ];
    }
}