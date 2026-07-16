<?php

namespace App\Contracts\Repositories;

use App\Models\PlanificacionDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanificacionDiariaRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15, ?string $search = null, ?array $personaCargoCursadoIds = null): LengthAwarePaginator;

    public function getById(PlanificacionDiaria $planificacionDiaria): PlanificacionDiaria;

    public function create(array $data): PlanificacionDiaria;

    public function update(PlanificacionDiaria $planificacionDiaria, array $data): PlanificacionDiaria;

    public function delete(PlanificacionDiaria $planificacionDiaria): bool;
}
