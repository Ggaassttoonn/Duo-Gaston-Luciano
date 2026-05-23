<?php

namespace App\Contracts\Repositories;

use App\Models\Cargo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CargoRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        Cargo $cargo
    ): Cargo;

    public function create(
        array $data
    ): Cargo;

    public function update(
        Cargo $cargo,
        array $data
    ): Cargo;

    public function delete(
        Cargo $cargo
    ): bool;
}