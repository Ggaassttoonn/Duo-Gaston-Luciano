<?php

namespace App\Services;

use App\Contracts\Repositories\EstadoAnualRepositoryInterface;
use App\Contracts\Interfaces\EstadoAnualServiceInterface;
use App\Models\EstadoAnual;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EstadoAnualService implements EstadoAnualServiceInterface
{
    public function __construct(
        protected EstadoAnualRepositoryInterface $repository
    ) {}

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function getById(EstadoAnual $estadoAnual): EstadoAnual
    {
        return $this->repository->find($estadoAnual);
    }

    public function getSelectOptions(): array
    {
        return [
            'planificacionesAnuales' =>
                $this->repository->getPlanificacionesConRelaciones(),
        ];
    }

    public function create(array $data): EstadoAnual
    {
        return $this->repository->create($data);
    }

    public function update(EstadoAnual $estadoAnual, array $data): EstadoAnual
    {
        return $this->repository->update($estadoAnual, $data);
    }

    public function delete(EstadoAnual $estadoAnual): bool
    {
        return $this->repository->delete($estadoAnual);
    }
}