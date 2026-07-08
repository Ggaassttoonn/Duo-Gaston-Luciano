<?php

namespace App\Http\Requests\PlanificacionDiaria;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanificacionDiariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_estimada'           => 'required|date',
            'fecha_desarrollada'       => 'nullable|date', 
            'fecha_presentacion'       => 'required|date',
            'contenidos_especificos'   => 'required|string',
            'actividades'              => 'required|string',
            'tareas'                   => 'nullable|string',
            'persona_cargo_cursado_id' => 'required|exists:persona_cargo_cursados,id',
            'tipo_planificacion'       => 'required|string|max:255',
        ];
    }
}