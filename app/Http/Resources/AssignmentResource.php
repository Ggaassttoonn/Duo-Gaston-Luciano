<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AssignmentResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'deadline_id' => $this->deadline_id,
            'user_id' => $this->user_id,
            'profesor' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],
            'status' => $this->status,
            'respuesta' => $this->respuesta,
            'submitted_at' => $this->submitted_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
