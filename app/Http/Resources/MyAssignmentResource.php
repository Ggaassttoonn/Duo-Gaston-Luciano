<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class MyAssignmentResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        $deadline = $this->deadline;

        return [
            'id' => $this->id,
            'deadline_id' => $this->deadline_id,
            'titulo' => $deadline->titulo,
            'descripcion' => $deadline->descripcion,
            'fecha_limite' => $deadline->fecha_limite?->toISOString(),
            'deadline' => [
                'id' => $deadline->id,
                'titulo' => $deadline->titulo,
                'descripcion' => $deadline->descripcion,
                'fecha_limite' => $deadline->fecha_limite?->toISOString(),
                'director' => [
                    'id' => $deadline->director?->id,
                    'name' => $deadline->director?->name,
                ],
            ],
            'director' => [
                'id' => $deadline->director?->id,
                'name' => $deadline->director?->name,
            ],
            'status' => $this->status,
            'respuesta' => $this->respuesta,
            'submitted_at' => $this->submitted_at?->toISOString(),
        ];
    }
}
