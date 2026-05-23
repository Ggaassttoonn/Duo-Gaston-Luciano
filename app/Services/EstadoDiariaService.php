<?php

namespace App\Services;

use App\Contracts\Repositories\EstadoDiariaRepositoryInterface;
use App\Contracts\Interfaces\EstadoDiariaServiceInterface;
use App\Models\EstadoDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EstadoDiariaService implements EstadoDiariaServiceInterface
{
    public function __construct(
        protected EstadoDiariaRepositoryInterface $repository
    ) {}

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function getById(EstadoDiaria $estadoDiaria): EstadoDiaria
    {
        return $this->repository->find($estadoDiaria);
    }

    public function getSelectOptions(): array
    {
        return [
            'planificacionesDiarias' =>
                $this->repository->getPlanificacionesConRelaciones(),
        ];
    }

    public function create(array $data): EstadoDiaria
    {
        return $this->repository->create($data);
    }

    public function update(EstadoDiaria $estadoDiaria, array $data): EstadoDiaria
    {
        return $this->repository->update($estadoDiaria, $data);
    }

    public function delete(EstadoDiaria $estadoDiaria): bool
    {
        return $this->repository->delete($estadoDiaria);
    }
}