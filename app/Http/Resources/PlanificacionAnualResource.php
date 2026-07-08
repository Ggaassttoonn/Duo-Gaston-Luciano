<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PlanificacionAnualResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha_presentacion' => $this->fecha_presentacion?->format('Y-m-d'),
            'aprendizajes_esperados' => $this->aprendizajes_esperados,
            'saberes' => $this->saberes,
            'criterios' => $this->criterios,
            'bibliografia' => $this->bibliografia,
            'diagnostico' => $this->diagnostico,
            'area_id' => $this->area_id,
            'persona_cargo_cursado_id' => $this->persona_cargo_cursado_id,
            'tipo_planificacion' => $this->tipo_planificacion,
            'area' => AreaResource::make($this->whenLoaded('area')),
            'persona_cargo_cursado' => PersonaCargoCursadoResource::make($this->whenLoaded('personaCargoCursado')),
            'estados_anuales' => EstadoAnualResource::collection($this->whenLoaded('estadosAnuales')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
