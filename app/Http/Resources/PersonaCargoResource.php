<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PersonaCargoResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'personas_id' => $this->personas_id,
            'cargos_id' => $this->cargos_id,
            'sit_revista_id' => $this->sit_revista_id,
            'persona' => PersonaResource::make($this->whenLoaded('persona')),
            'cargo' => CargoResource::make($this->whenLoaded('cargo')),
            'sit_revista' => SitRevistaResource::make($this->whenLoaded('sitRevista')),
            'persona_cargo_cursados' => PersonaCargoCursadoResource::collection($this->whenLoaded('personaCargoCursados')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
