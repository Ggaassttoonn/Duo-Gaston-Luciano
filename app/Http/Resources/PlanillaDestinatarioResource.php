<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PlanillaDestinatarioResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'planilla_id' => $this->planilla_id,
            'director_id' => $this->director_id,
            'comentario' => $this->comentario,
            'audio' => $this->audio,
            'leido' => $this->leido,
            'planilla' => PlanillaResource::make($this->whenLoaded('planilla')),
            'director' => UsersResource::make($this->whenLoaded('director')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
