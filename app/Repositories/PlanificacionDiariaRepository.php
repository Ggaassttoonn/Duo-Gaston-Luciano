<?php

namespace App\Repositories;

use App\Models\PlanificacionDiaria;
use App\Contracts\Repositories\PlanificacionDiariaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlanificacionDiariaRepository implements PlanificacionDiariaRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15, ?string $search = null, ?array $personaCargoCursadoIds = null): LengthAwarePaginator
    {
        $query = PlanificacionDiaria::with([
            'personaCargoCursado.personaCargo.persona',
            'personaCargoCursado.personaCargo.cargo',
            'personaCargoCursado.cursado.curso',
            'estadosDiarios',
        ]);

        if ($personaCargoCursadoIds !== null) {
            $query->whereIn('persona_cargo_cursado_id', $personaCargoCursadoIds);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('personaCargoCursado.personaCargo.persona', function ($personaQuery) use ($search) {
                    $personaQuery->where('apellidos', 'like', "%{$search}%")
                        ->orWhere('nombres', 'like', "%{$search}%");
                })
                ->orWhere('contenidos_especificos', 'like', "%{$search}%")
                ->orWhere('actividades', 'like', "%{$search}%")
                ->orWhere('tareas', 'like', "%{$search}%")
                ->orWhere('tipo_planificacion', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
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
