<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PersonaCargoCursadoResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'persona_cargos_id' => $this->persona_cargos_id,
            'cursados_id' => $this->cursados_id,
            'persona_cargo' => PersonaCargoResource::make($this->whenLoaded('personaCargo')),
            'cursado' => CursadoResource::make($this->whenLoaded('cursado')),
            'planificaciones_anuales' => PlanificacionAnualResource::collection($this->whenLoaded('planificacionesAnuales')),
            'planificaciones_diarias' => PlanificacionDiariaResource::collection($this->whenLoaded('planificacionesDiarias')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
