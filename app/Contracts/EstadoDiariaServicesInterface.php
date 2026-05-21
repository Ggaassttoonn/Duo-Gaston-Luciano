<?php

namespace App\Contracts;

use App\Models\EstadoDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EstadoDiariaServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        EstadoDiaria $estadoDiaria
    ): EstadoDiaria;

    public function getSelectOptions(): array;

    public function create(
        array $data
    ): EstadoDiaria;

    public function update(
        EstadoDiaria $estadoDiaria,
        array $data
    ): EstadoDiaria;

    public function delete(
        EstadoDiaria $estadoDiaria
    ): bool;
}