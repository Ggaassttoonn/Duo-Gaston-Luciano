<?php

namespace App\Services;

use App\Models\Cursado;
use App\Contracts\CursadoServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\CursadoRepositoryInterface;

class CursadoService implements CursadoServiceInterface
{
    public function __construct(
        private CursadoRepositoryInterface $cursadoRepository
    ) {
    }

    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->cursadoRepository
            ->getAllPaginated($perPage);
    }

    public function getById(
        Cursado $cursado
    ): Cursado {
        return $this->cursadoRepository
            ->getById($cursado);
    }

    public function create(
        array $data
    ): Cursado {
        return $this->cursadoRepository
            ->create($data);
    }

    public function update(
        Cursado $cursado,
        array $data
    ): Cursado {
        return $this->cursadoRepository
            ->update($cursado, $data);
    }

    public function delete(
        Cursado $cursado
    ): bool {
        return $this->cursadoRepository
            ->delete($cursado);
    }
}