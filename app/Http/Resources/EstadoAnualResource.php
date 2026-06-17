<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class EstadoAnualResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
            'fecha' => $this->fecha?->format('Y-m-d'),
            'planificacion_anual_id' => $this->planificacion_anual_id,
            'planificacion_anual' => PlanificacionAnualResource::make($this->whenLoaded('planificacionAnual')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
