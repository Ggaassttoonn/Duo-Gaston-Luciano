<?php

namespace App\Contracts\Interfaces;

use App\Models\PlanificacionAnual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanificacionAnualServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        PlanificacionAnual $planificacionAnual
    ): PlanificacionAnual;

    public function getSelectOptions(): array;

    public function create(
        array $data
    ): PlanificacionAnual;

    public function update(
        PlanificacionAnual $planificacionAnual,
        array $data
    ): PlanificacionAnual;

    public function delete(
        PlanificacionAnual $planificacionAnual
    ): bool;
}