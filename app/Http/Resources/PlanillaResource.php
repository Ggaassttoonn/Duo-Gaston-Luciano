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
            'user_id' => $this->user_id,
            'docente_id' => $this->user_id,
            'estado' => $this->estado,
            'user' => UsersResource::make($this->whenLoaded('user')),
            'destinatarios' => PlanillaDestinatarioResource::collection($this->whenLoaded('destinatarios')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
