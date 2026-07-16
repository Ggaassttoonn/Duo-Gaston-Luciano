<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UsersResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'persona_id' => $this->persona_id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'foto' => $this->foto,
            'persona' => PersonaResource::make($this->whenLoaded('persona')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
