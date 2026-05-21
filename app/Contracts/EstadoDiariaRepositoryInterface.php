<?php

namespace App\Contracts;

use App\Models\EstadoDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EstadoDiariaRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(EstadoDiaria $estadoDiaria): EstadoDiaria;

    public function create(array $data): EstadoDiaria;

    public function update(EstadoDiaria $estadoDiaria, array $data): EstadoDiaria;

    public function delete(EstadoDiaria $estadoDiaria): bool;

    public function getPlanificacionesConRelaciones(): Collection;
}