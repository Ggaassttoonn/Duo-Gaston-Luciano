<?php

namespace App\Repositories;

use App\Models\Materia;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\MateriaRepositoryInterface;

class MateriaRepository implements MateriaRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Materia::with('area')->paginate($perPage);
    }

    public function getById(Materia $materia): Materia
    {
        return $materia->load('area');
    }

    public function create(array $data): Materia
    {
        return Materia::create($data);
    }

    public function update(Materia $materia, array $data): Materia
    {
        $materia->update($data);

        return $materia;
    }

    public function delete(Materia $materia): bool
    {
        return $materia->delete();
    }
}
