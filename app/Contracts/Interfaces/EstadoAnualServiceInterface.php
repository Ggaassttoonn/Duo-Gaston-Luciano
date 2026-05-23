<?php

namespace App\Contracts\Interfaces;

use App\Models\EstadoAnual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EstadoAnualServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        EstadoAnual $estadoAnual
    ): EstadoAnual;

    public function getSelectOptions(): array;

    public function create(
        array $data
    ): EstadoAnual;

    public function update(
        EstadoAnual $estadoAnual,
        array $data
    ): EstadoAnual;

    public function delete(
        EstadoAnual $estadoAnual
    ): bool;
}