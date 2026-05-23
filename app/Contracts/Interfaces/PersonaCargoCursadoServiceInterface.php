<?php

namespace App\Contracts\Interfaces;

use App\Models\PersonaCargoCursado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PersonaCargoCursadoServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        PersonaCargoCursado $personaCargoCursado
    ): PersonaCargoCursado;

    public function getSelectOptions(): array;

    public function create(
        array $data
    ): PersonaCargoCursado;

    public function update(
        PersonaCargoCursado $personaCargoCursado,
        array $data
    ): PersonaCargoCursado;

    public function delete(
        PersonaCargoCursado $personaCargoCursado
    ): bool;
}