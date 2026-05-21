<?php

namespace App\Services;

use App\Models\Cursado;
use App\Models\PersonaCargo;
use App\Models\PersonaCargoCursado;
use App\Contracts\PersonaCargoCursadoServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonaCargoCursadoService implements PersonaCargoCursadoServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return PersonaCargoCursado::with([
            'personaCargo',
            'cursado',
        ])->paginate($perPage);
    }

    public function getById(
        PersonaCargoCursado $personaCargoCursado
    ): PersonaCargoCursado {
        return $personaCargoCursado->load([
            'personaCargo',
            'cursado',
            'planificacionesAnuales',
            'planificacionesDiarias',
        ]);
    }

    public function getSelectOptions(): array
    {
        return [
            'personaCargos' => PersonaCargo::with([
                'persona',
                'cargo',
            ])->get(),

            'cursados' => Cursado::with([
                'curso',
            ])->get(),
        ];
    }

    public function create(
        array $data
    ): PersonaCargoCursado {
        return PersonaCargoCursado::create($data);
    }

    public function update(
        PersonaCargoCursado $personaCargoCursado,
        array $data
    ): PersonaCargoCursado {
        $personaCargoCursado->update($data);

        return $personaCargoCursado;
    }

    public function delete(
        PersonaCargoCursado $personaCargoCursado
    ): bool {
        return $personaCargoCursado->delete();
    }
}