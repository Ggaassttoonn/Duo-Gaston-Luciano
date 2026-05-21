<?php

namespace App\Services;

use App\Models\Curso;
use App\Contracts\CursoServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CursoService implements CursoServiceInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Curso::paginate($perPage);
    }

    public function getById(Curso $curso): Curso
    {
        return $curso->load('cursados');
    }

    public function create(array $data): Curso
    {
        return Curso::create($data);
    }

    public function update(Curso $curso, array $data): Curso
    {
        $curso->update($data);

        return $curso;
    }

    public function delete(Curso $curso): bool
    {
        return $curso->delete();
    }
}