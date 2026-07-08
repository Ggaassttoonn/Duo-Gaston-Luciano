<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class DeadlineResource extends BaseResource
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
            'profesores_asignados' => $this->assignments->map(fn($a) => [
                'id' => $a->user_id,
                'name' => $a->user?->name,
                'pivot' => [
                    'status' => $a->status,
                    'submitted_at' => $a->submitted_at?->toISOString(),
                ],
            ]),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
