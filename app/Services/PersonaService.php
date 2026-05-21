<?php

namespace App\Services;

use App\Models\Persona;
use App\Contracts\PersonaServiceInterface;
use App\Contracts\Repositories\PersonaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonaService implements PersonaServiceInterface
{
    public function __construct(
        private PersonaRepositoryInterface $personaRepository
    ) {}

    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->personaRepository->getAllPaginated($perPage);
    }

    public function getById(
        Persona $persona
    ): Persona {
        return $this->personaRepository->getById($persona);
    }

    public function create(array $data): Persona
    {
        return $this->personaRepository->create($data);
    }

    public function update(
        Persona $persona,
        array $data
    ): Persona {
        return $this->personaRepository->update($persona, $data);
    }

    public function delete(
        Persona $persona
    ): bool {
        return $this->personaRepository->delete($persona);
    }

    public function restore(
        Persona $persona
    ): bool {
        return $this->personaRepository->restore($persona);
    }
}