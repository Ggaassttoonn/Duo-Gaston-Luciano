<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PlanillaStateResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'planilla_id' => $this->planilla_id,
            'user_id' => $this->user_id,
            'estado' => $this->estado,
            'planilla' => PlanillaResource::make($this->whenLoaded('planilla')),
            'user' => UsersResource::make($this->whenLoaded('user')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
