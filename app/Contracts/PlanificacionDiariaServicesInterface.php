<?php

namespace App\Contracts;

use App\Models\PlanificacionDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanificacionDiariaServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        PlanificacionDiaria $planificacionDiaria
    ): PlanificacionDiaria;

    public function getSelectOptions(): array;

    public function create(
        array $data
    ): PlanificacionDiaria;

    public function update(
        PlanificacionDiaria $planificacionDiaria,
        array $data
    ): PlanificacionDiaria;

    public function delete(
        PlanificacionDiaria $planificacionDiaria
    ): bool;
}