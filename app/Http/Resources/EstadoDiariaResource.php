<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class EstadoDiariaResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
            'fecha' => $this->fecha?->format('Y-m-d'),
            'planificacion_diaria_id' => $this->planificacion_diaria_id,
            'planificacion_diaria' => PlanificacionDiariaResource::make($this->whenLoaded('planificacionDiaria')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
