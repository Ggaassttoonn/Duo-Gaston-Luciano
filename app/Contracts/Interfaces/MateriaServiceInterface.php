<?php

namespace App\Contracts\Interfaces;

use App\Models\Materia;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MateriaServiceInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getById(Materia $materia): Materia;

    public function create(array $data): Materia;

    public function update(Materia $materia, array $data): Materia;

    public function delete(Materia $materia): bool;
}
