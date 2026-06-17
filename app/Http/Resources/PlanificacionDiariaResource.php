<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PlanificacionDiariaResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha_estimada' => $this->fecha_estimada?->format('Y-m-d'),
            'fecha_desarrollada' => $this->fecha_desarrollada?->format('Y-m-d'),
            'fecha_presentacion' => $this->fecha_presentacion?->format('Y-m-d'),
            'contenidos_especificos' => $this->contenidos_especificos,
            'actividades' => $this->actividades,
            'tareas' => $this->tareas,
            'persona_cargo_cursado_id' => $this->persona_cargo_cursado_id,
            'tipo_planificacion' => $this->tipo_planificacion,
            'persona_cargo_cursado' => PersonaCargoCursadoResource::make($this->whenLoaded('personaCargoCursado')),
            'estados_diarios' => EstadoDiariaResource::collection($this->whenLoaded('estadosDiarios')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
