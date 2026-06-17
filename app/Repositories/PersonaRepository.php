<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Contracts\Repositories\PersonaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonaRepository implements PersonaRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Persona::with('cargos')->paginate($perPage);
    }

    public function getById(Persona $persona): Persona
    {
        return $persona->load('cargos');
    }

    public function create(array $data): Persona
    {
        return Persona::create($data);
    }

    public function update(Persona $persona, array $data): Persona
    {
        $persona->update($data);

        return $persona;
    }

    public function delete(Persona $persona): bool
    {
        return $persona->delete();
    }

    public function restore(Persona $persona): bool
    {
        return $persona->restore();
    }
}
