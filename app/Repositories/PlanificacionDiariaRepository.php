<?php

namespace App\Repositories;

use App\Models\PlanificacionDiaria;
use App\Contracts\Repositories\PlanificacionDiariaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlanificacionDiariaRepository implements PlanificacionDiariaRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PlanificacionDiaria::with([
            'personaCargoCursado',
        ])->paginate($perPage);
    }

    public function getById(PlanificacionDiaria $planificacionDiaria): PlanificacionDiaria
    {
        return $planificacionDiaria->load([
            'personaCargoCursado',
            'estadosDiarios',
        ]);
    }

    public function create(array $data): PlanificacionDiaria
    {
        return PlanificacionDiaria::create($data);
    }

    public function update(PlanificacionDiaria $planificacionDiaria, array $data): PlanificacionDiaria
    {
        $planificacionDiaria->update($data);

        return $planificacionDiaria;
    }

    public function delete(PlanificacionDiaria $planificacionDiaria): bool
    {
        return $planificacionDiaria->delete();
    }
}
