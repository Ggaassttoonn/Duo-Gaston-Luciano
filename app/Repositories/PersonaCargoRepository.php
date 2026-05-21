<?php

namespace App\Repositories;

use App\Models\PersonaCargo;
use App\Contracts\Repositories\PersonaCargoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonaCargoRepository implements PersonaCargoRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PersonaCargo::with([
            'persona',
            'cargo',
            'sitRevista',
        ])->paginate($perPage);
    }

    public function getById(PersonaCargo $personaCargo): PersonaCargo
    {
        return $personaCargo->load([
            'persona',
            'cargo',
            'sitRevista',
            'personaCargoCursados',
        ]);
    }

    public function create(array $data): PersonaCargo
    {
        return PersonaCargo::create($data);
    }

    public function update(PersonaCargo $personaCargo, array $data): PersonaCargo
    {
        $personaCargo->update($data);

        return $personaCargo;
    }

    public function delete(PersonaCargo $personaCargo): bool
    {
        return $personaCargo->delete();
    }
}
