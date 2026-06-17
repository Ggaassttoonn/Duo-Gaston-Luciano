<?php

namespace App\Repositories;

use App\Models\Cargo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\CargoRepositoryInterface;

class CargoRepository implements CargoRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return Cargo::with('personaCargos')->paginate($perPage);
    }

    public function getById(
        Cargo $cargo
    ): Cargo {
        return $cargo->load('personaCargos');
    }

    public function create(
        array $data
    ): Cargo {
        return Cargo::create($data);
    }

    public function update(
        Cargo $cargo,
        array $data
    ): Cargo {
        $cargo->update($data);

        return $cargo;
    }

    public function delete(
        Cargo $cargo
    ): bool {
        return $cargo->delete();
    }
}

