<?php

namespace App\Repositories;

use App\Models\PlanificacionAnual;
use App\Contracts\Repositories\PlanificacionAnualRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlanificacionAnualRepository implements PlanificacionAnualRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return PlanificacionAnual::with([
            'area',
            'personaCargoCursado',
        ])->paginate($perPage);
    }

    public function getById(PlanificacionAnual $planificacionAnual): PlanificacionAnual
    {
        return $planificacionAnual->load([
            'area',
            'personaCargoCursado',
            'estadosAnuales',
        ]);
    }

    public function create(array $data): PlanificacionAnual
    {
        return PlanificacionAnual::create($data);
    }

    public function update(PlanificacionAnual $planificacionAnual, array $data): PlanificacionAnual
    {
        $planificacionAnual->update($data);

        return $planificacionAnual;
    }

    public function delete(PlanificacionAnual $planificacionAnual): bool
    {
        return $planificacionAnual->delete();
    }
}
