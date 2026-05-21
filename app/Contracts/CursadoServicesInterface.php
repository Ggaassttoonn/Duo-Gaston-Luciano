<?php

namespace App\Contracts;

use App\Models\Cursado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CursadoServiceInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getById(Cursado $cursado): Cursado;

    public function create(array $data): Cursado;

    public function update(Cursado $cursado, array $data): Cursado;

    public function delete(Cursado $cursado): bool;
}