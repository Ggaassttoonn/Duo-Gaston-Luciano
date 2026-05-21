<?php

namespace App\Repositories;

use App\Contracts\EstadoDiariaRepositoryInterface;
use App\Models\EstadoDiaria;
use App\Models\PlanificacionDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EstadoDiariaRepository implements EstadoDiariaRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return EstadoDiaria::with('planificacionDiaria')
            ->paginate($perPage);
    }

    public function find(EstadoDiaria $estadoDiaria): EstadoDiaria
    {
        return $estadoDiaria->load('planificacionDiaria');
    }

    public function create(array $data): EstadoDiaria
    {
        return EstadoDiaria::create($data);
    }

    public function update(EstadoDiaria $estadoDiaria, array $data): EstadoDiaria
    {
        $estadoDiaria->update($data);
        return $estadoDiaria;
    }

    public function delete(EstadoDiaria $estadoDiaria): bool
    {
        return $estadoDiaria->delete();
    }

    public function getPlanificacionesConRelaciones(): Collection
    {
        return PlanificacionDiaria::with([
            'personaCargoCursado',
        ])->get();
    }
}