<?php

namespace App\Repositories;

use App\Models\Curso;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\CursoRepositoryInterface;

class CursoRepository implements CursoRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return Curso::paginate($perPage);
    }

    public function getById(
        Curso $curso
    ): Curso {
        return $curso->load('cursados');
    }

    public function create(
        array $data
    ): Curso {
        return Curso::create($data);
    }

    public function update(
        Curso $curso,
        array $data
    ): Curso {
        $curso->update($data);

        return $curso;
    }

    public function delete(
        Curso $curso
    ): bool {
        return $curso->delete();
    }
}