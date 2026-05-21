<?php

namespace App\Contracts;

use App\Models\EstadoAnual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EstadoAnualRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(EstadoAnual $estadoAnual): EstadoAnual;

    public function create(array $data): EstadoAnual;

    public function update(EstadoAnual $estadoAnual, array $data): EstadoAnual;

    public function delete(EstadoAnual $estadoAnual): bool;

    public function getPlanificacionesConRelaciones(): Collection;
}