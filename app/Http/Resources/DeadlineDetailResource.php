<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class DeadlineDetailResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'fecha_limite' => $this->fecha_limite?->toISOString(),
            'director' => [
                'id' => $this->director?->id,
                'name' => $this->director?->name,
            ],
            'assignments' => $this->assignments->map(fn($a) => [
                'id' => $a->id,
                'user_id' => $a->user_id,
                'profesor' => [
                    'id' => $a->user?->id,
                    'name' => $a->user?->name,
                    'email' => $a->user?->email,
                ],
                'status' => $a->status,
                'respuesta' => $a->respuesta,
                'submitted_at' => $a->submitted_at?->toISOString(),
            ]),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
