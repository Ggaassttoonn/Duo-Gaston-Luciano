<?php

namespace App\Contracts\Repositories;

use App\Models\Area;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AreaRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        Area $area
    ): Area;

    public function create(
        array $data
    ): Area;

    public function update(
        Area $area,
        array $data
    ): Area;

    public function delete(
        Area $area
    ): bool;
}