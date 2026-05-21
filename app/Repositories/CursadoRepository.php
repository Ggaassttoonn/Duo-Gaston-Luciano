<?php

namespace App\Repositories;

use App\Models\Cursado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\CursadoRepositoryInterface;

class CursadoRepository implements CursadoRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return Cursado::with('curso')
            ->paginate($perPage);
    }

    public function getById(
        Cursado $cursado
    ): Cursado {
        return $cursado->load('curso');
    }

    public function create(
        array $data
    ): Cursado {
        return Cursado::create($data);
    }

    public function update(
        Cursado $cursado,
        array $data
    ): Cursado {
        $cursado->update($data);

        return $cursado;
    }

    public function delete(
        Cursado $cursado
    ): bool {
        return $cursado->delete();
    }
}