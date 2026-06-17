<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CargoResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cargo' => $this->cargo,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
