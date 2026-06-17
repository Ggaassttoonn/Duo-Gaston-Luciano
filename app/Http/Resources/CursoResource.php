<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CursoResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ciclo' => $this->ciclo,
            'grado' => $this->grado,
            'seccion' => $this->seccion,
            'turno' => $this->turno,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
