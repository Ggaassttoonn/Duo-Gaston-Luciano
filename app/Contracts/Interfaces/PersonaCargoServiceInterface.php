<?php

namespace App\Contracts\Interfaces;

use App\Models\PersonaCargo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PersonaCargoServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        PersonaCargo $personaCargo
    ): PersonaCargo;

    public function getSelectOptions(): array;

    public function create(
        array $data
    ): PersonaCargo;

    public function update(
        PersonaCargo $personaCargo,
        array $data
    ): PersonaCargo;

    public function delete(
        PersonaCargo $personaCargo
    ): bool;
}