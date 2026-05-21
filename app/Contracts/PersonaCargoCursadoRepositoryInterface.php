<?php

namespace App\Contracts\Repositories;

use App\Models\PersonaCargoCursado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PersonaCargoCursadoRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    public function findWithRelations(PersonaCargoCursado $personaCargoCursado): PersonaCargoCursado;

    public function getPersonaCargosOptions(): Collection;

    public function getCursadosOptions(): Collection;

    public function create(array $data): PersonaCargoCursado;

    public function update(PersonaCargoCursado $personaCargoCursado, array $data): PersonaCargoCursado;

    public function delete(PersonaCargoCursado $personaCargoCursado): bool;
}