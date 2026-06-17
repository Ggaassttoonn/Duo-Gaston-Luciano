<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PlanillaRevisionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'planilla_id' => $this->planilla_id,
            'director_id' => $this->director_id,
            'estado' => $this->estado,
            'comentario' => $this->comentario,
            'audio_base64' => $this->audio_base64,
            'audio_mime' => $this->audio_mime,
            'planilla_original_id' => $this->planilla_original_id,
            'planilla' => PlanillaResource::make($this->whenLoaded('planilla')),
            'director' => UsersResource::make($this->whenLoaded('director')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
