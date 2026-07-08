<?php

namespace App\Repositories;

use App\Models\PlanificacionAnual;
use App\Contracts\Repositories\PlanificacionAnualRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlanificacionAnualRepository implements PlanificacionAnualRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        $query = PlanificacionAnual::with([
            'area',
            'personaCargoCursado.personaCargo.persona',
            'personaCargoCursado.personaCargo.cargo',
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('area', function ($areaQuery) use ($search) {
                    $areaQuery->where('area', 'like', "%{$search}%");
                })
                ->orWhereHas('personaCargoCursado.personaCargo.persona', function ($personaQuery) use ($search) {
                    $personaQuery->where('apellidos', 'like', "%{$search}%")
                        ->orWhere('nombres', 'like', "%{$search}%");
                })
                ->orWhere('aprendizajes_esperados', 'like', "%{$search}%")
                ->orWhere('saberes', 'like', "%{$search}%")
                ->orWhere('criterios', 'like', "%{$search}%")
                ->orWhere('diagnostico', 'like', "%{$search}%")
                ->orWhere('tipo_planificacion', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
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
