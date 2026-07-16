<?php

namespace App\Services;

use App\Models\PersonaCargoCursado;
use App\Models\PlanificacionDiaria;
use App\Contracts\Interfaces\PlanificacionDiariaServiceInterface;
use App\Contracts\Repositories\PlanificacionDiariaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlanificacionDiariaService implements PlanificacionDiariaServiceInterface
{
    public function __construct(
        private PlanificacionDiariaRepositoryInterface $planificacionDiariaRepository
    ) {}

    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?array $personaCargoCursadoIds = null
    ): LengthAwarePaginator {
        return $this->planificacionDiariaRepository->getAllPaginated($perPage, $search, $personaCargoCursadoIds);
    }

    public function getById(
        PlanificacionDiaria $planificacionDiaria
    ): PlanificacionDiaria {
        return $this->planificacionDiariaRepository->getById($planificacionDiaria);
    }

    public function getSelectOptions(): array
    {
        return [
            'personaCargoCursados' => PersonaCargoCursado::with([
                'personaCargo.persona',
                'personaCargo.cargo',
                'cursado.curso',
            ])->get(),
        ];
    }

    public function create(
        array $data
    ): PlanificacionDiaria {
        return $this->planificacionDiariaRepository->create($data);
    }

    public function update(
        PlanificacionDiaria $planificacionDiaria,
        array $data
    ): PlanificacionDiaria {
        return $this->planificacionDiariaRepository->update($planificacionDiaria, $data);
    }

    public function delete(
        PlanificacionDiaria $planificacionDiaria
    ): bool {
        return $this->planificacionDiariaRepository->delete($planificacionDiaria);
    }
}
