<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PersonaResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'apellidos' => $this->apellidos,
            'nombres' => $this->nombres,
            'dni' => $this->dni,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'fecha_nacimiento' => $this->fecha_nacimiento?->format('Y-m-d'),
            'cargos' => PersonaCargoResource::collection($this->whenLoaded('cargos')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
