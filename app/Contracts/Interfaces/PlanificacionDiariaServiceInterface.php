<?php

namespace App\Contracts\Interfaces;

use App\Models\PlanificacionDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanificacionDiariaServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?array $personaCargoCursadoIds = null
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