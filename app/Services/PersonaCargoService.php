<?php

namespace App\Services;

use App\Models\Cargo;
use App\Models\Persona;
use App\Models\PersonaCargo;
use App\Models\SitRevista;
use App\Contracts\Interfaces\PersonaCargoServiceInterface;
use App\Contracts\Repositories\PersonaCargoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonaCargoService implements PersonaCargoServiceInterface
{
    public function __construct(
        private PersonaCargoRepositoryInterface $personaCargoRepository
    ) {}

    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->personaCargoRepository->getAllPaginated($perPage);
    }

    public function getById(
        PersonaCargo $personaCargo
    ): PersonaCargo {
        return $this->personaCargoRepository->getById($personaCargo);
    }

    public function getSelectOptions(): array
    {
        return [
            'personas' => Persona::all(),
            'cargos' => Cargo::all(),
            'sitRevistas' => SitRevista::all(),
        ];
    }

    public function create(array $data): PersonaCargo
    {
        return $this->personaCargoRepository->create($data);
    }

    public function update(
        PersonaCargo $personaCargo,
        array $data
    ): PersonaCargo {
        return $this->personaCargoRepository->update($personaCargo, $data);
    }

    public function delete(
        PersonaCargo $personaCargo
    ): bool {
        return $this->personaCargoRepository->delete($personaCargo);
    }
}