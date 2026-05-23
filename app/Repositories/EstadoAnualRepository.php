<?php

namespace App\Repositories;

use App\Contracts\Repositories\EstadoAnualRepositoryInterface;
use App\Models\EstadoAnual;
use App\Models\PlanificacionAnual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EstadoAnualRepository implements EstadoAnualRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return EstadoAnual::with('planificacionAnual')
            ->paginate($perPage);
    }

    public function find(EstadoAnual $estadoAnual): EstadoAnual
    {
        return $estadoAnual->load('planificacionAnual');
    }

    public function create(array $data): EstadoAnual
    {
        return EstadoAnual::create($data);
    }

    public function update(EstadoAnual $estadoAnual, array $data): EstadoAnual
    {
        $estadoAnual->update($data);
        return $estadoAnual;
    }

    public function delete(EstadoAnual $estadoAnual): bool
    {
        return $estadoAnual->delete();
    }

    public function getPlanificacionesConRelaciones(): Collection
    {
        return PlanificacionAnual::with([
            'area',
            'personaCargoCursado',
        ])->get();
    }
}