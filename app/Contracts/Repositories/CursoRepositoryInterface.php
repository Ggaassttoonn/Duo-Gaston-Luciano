<?php

namespace App\Contracts\Repositories;

use App\Models\Curso;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CursoRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        Curso $curso
    ): Curso;

    public function create(
        array $data
    ): Curso;

    public function update(
        Curso $curso,
        array $data
    ): Curso;

    public function delete(
        Curso $curso
    ): bool;
}