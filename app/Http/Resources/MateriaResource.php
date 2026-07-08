<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class MateriaResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'area_id' => $this->area_id,
            'area' => AreaResource::make($this->whenLoaded('area')),
            'primer_ciclo' => $this->primer_ciclo,
            'segundo_ciclo' => $this->segundo_ciclo,
            'tercer_ciclo' => $this->tercer_ciclo,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
