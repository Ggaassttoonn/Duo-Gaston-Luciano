<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CursadoResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'anio_lectivo' => $this->anio_lectivo,
            'fecha_inicio' => $this->fecha_inicio?->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin?->format('Y-m-d'),
            'curso_id' => $this->curso_id,
            'curso' => CursoResource::make($this->whenLoaded('curso')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
