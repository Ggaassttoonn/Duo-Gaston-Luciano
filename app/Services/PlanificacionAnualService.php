<?php

namespace App\Services;

use App\Models\Area;
use App\Models\PersonaCargoCursado;
use App\Models\PlanificacionAnual;
use App\Contracts\PlanificacionAnualServiceInterface;
use App\Contracts\Repositories\PlanificacionAnualRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlanificacionAnualService implements PlanificacionAnualServiceInterface
{
    public function __construct(
        private PlanificacionAnualRepositoryInterface $planificacionAnualRepository
    ) {}

    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->planificacionAnualRepository->getAllPaginated($perPage);
    }

    public function getById(
        PlanificacionAnual $planificacionAnual
    ): PlanificacionAnual {
        return $this->planificacionAnualRepository->getById($planificacionAnual);
    }

    public function getSelectOptions(): array
    {
        return [
            'areas' => Area::all(),

            'personaCargoCursados' => PersonaCargoCursado::with([
                'personaCargo.persona',
                'personaCargo.cargo',
                'cursado.curso',
            ])->get(),
        ];
    }

    public function create(
        array $data
    ): PlanificacionAnual {
        return $this->planificacionAnualRepository->create($data);
    }

    public function update(
        PlanificacionAnual $planificacionAnual,
        array $data
    ): PlanificacionAnual {
        return $this->planificacionAnualRepository->update($planificacionAnual, $data);
    }

    public function delete(
        PlanificacionAnual $planificacionAnual
    ): bool {
        return $this->planificacionAnualRepository->delete($planificacionAnual);
    }
}
