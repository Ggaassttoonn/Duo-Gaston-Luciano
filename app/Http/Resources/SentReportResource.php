<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class SentReportResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'director_id' => $this->director_id,
            'planilla_id' => $this->planilla_id,
            'docente_id' => $this->docente_id,
            'comentario' => $this->comentario,
            'audio_base64' => $this->audio_base64,
            'audio_mime' => $this->audio_mime,
            'director' => UsersResource::make($this->whenLoaded('director')),
            'planilla' => PlanillaResource::make($this->whenLoaded('planilla')),
            'docente' => UsersResource::make($this->whenLoaded('docente')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
