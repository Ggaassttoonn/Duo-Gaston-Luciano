<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PlanillaResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'persona_id' => $this->persona_id,
            'estado' => $this->estado,
            'persona' => UsersResource::make($this->whenLoaded('persona')),
            'destinatarios' => PlanillaDestinatarioResource::collection($this->whenLoaded('destinatarios')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
