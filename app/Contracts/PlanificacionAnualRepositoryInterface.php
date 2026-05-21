<?php

namespace App\Contracts\Repositories;

use App\Models\PlanificacionAnual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanificacionAnualRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getById(PlanificacionAnual $planificacionAnual): PlanificacionAnual;

    public function create(array $data): PlanificacionAnual;

    public function update(PlanificacionAnual $planificacionAnual, array $data): PlanificacionAnual;

    public function delete(PlanificacionAnual $planificacionAnual): bool;
}
