<?php

namespace App\Repositories;

use App\Contracts\Repositories\PersonaCargoCursadoRepositoryInterface;
use App\Models\PersonaCargoCursado;
use App\Models\PersonaCargo;
use App\Models\Cursado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PersonaCargoCursadoRepository implements PersonaCargoCursadoRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PersonaCargoCursado::with([
            'personaCargo',
            'cursado',
        ])->paginate($perPage);
    }

    public function findWithRelations(PersonaCargoCursado $personaCargoCursado): PersonaCargoCursado
    {
        return $personaCargoCursado->load([
            'personaCargo',
            'cursado',
            'planificacionesAnuales',
            'planificacionesDiarias',
        ]);
    }

    public function create(array $data): PersonaCargoCursado
    {
        return PersonaCargoCursado::create($data);
    }

    public function update(PersonaCargoCursado $personaCargoCursado, array $data): PersonaCargoCursado
    {
        $personaCargoCursado->update($data);
        return $personaCargoCursado;
    }

    public function delete(PersonaCargoCursado $personaCargoCursado): bool
    {
        return $personaCargoCursado->delete();
    }

    public function getPersonaCargosOptions(): Collection
    {
        return PersonaCargo::with([
            'persona',
            'cargo',
        ])->get();
    }

    public function getCursadosOptions(): Collection
    {
        return Cursado::with([
            'curso',
        ])->get();
    }
}