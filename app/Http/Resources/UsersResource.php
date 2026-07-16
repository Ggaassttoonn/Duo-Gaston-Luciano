<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UsersResource extends BaseResource
{
    private function fixFotoUrl(?string $url, Request $request): ?string
    {
        if (!$url) {
            return null;
        }

        $url = str_replace(
            ['http://localhost:8000', 'http://localhost'],
            $request->getSchemeAndHttpHost(),
            $url
        );

        return $url;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'persona_id' => $this->persona_id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'foto' => $this->fixFotoUrl($this->foto, $request),
            'persona' => PersonaResource::make($this->whenLoaded('persona')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
