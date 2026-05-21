<?php

namespace App\Contracts;

use App\Models\Persona;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PersonaServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        Persona $persona
    ): Persona;

    public function create(
        array $data
    ): Persona;

    public function update(
        Persona $persona,
        array $data
    ): Persona;

    public function delete(
        Persona $persona
    ): bool;

    public function restore(
        Persona $persona
    ): bool;
}