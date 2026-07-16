<?php

namespace App\Traits;

use App\Models\Users;

trait ResolvesPersonaCargoCursadoIds
{
    private function getPersonaCargoCursadoIds(Users $user): ?array
    {
        if (!$user->persona) {
            return [];
        }

        return $user->persona
            ->cargos()
            ->with('personaCargoCursados')
            ->get()
            ->pluck('personaCargoCursados')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->values()
            ->toArray();
    }
}
