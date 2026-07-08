<?php

namespace App\Services;

use App\Models\Materia;
use App\Contracts\Interfaces\MateriaServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\MateriaRepositoryInterface;

class MateriaService implements MateriaServiceInterface
{
    public function __construct(
        private MateriaRepositoryInterface $materiaRepository
    ) {}

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->materiaRepository->getAllPaginated($perPage);
    }

    public function getById(Materia $materia): Materia
    {
        return $this->materiaRepository->getById($materia);
    }

    public function create(array $data): Materia
    {
        return $this->materiaRepository->create($data);
    }

    public function update(Materia $materia, array $data): Materia
    {
        return $this->materiaRepository->update($materia, $data);
    }

    public function delete(Materia $materia): bool
    {
        return $this->materiaRepository->delete($materia);
    }
}
