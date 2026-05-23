<?php

namespace App\Services;

use App\Models\Cargo;
use App\Contracts\Interfaces\CargoServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\CargoRepositoryInterface;

class CargoService implements CargoServiceInterface
{
    public function __construct(
        private CargoRepositoryInterface $cargoRepository
    ) {
    }

    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->cargoRepository
            ->getAllPaginated($perPage);
    }

    public function getById(
        Cargo $cargo
    ): Cargo {
        return $this->cargoRepository
            ->getById($cargo);
    }

    public function create(
        array $data
    ): Cargo {
        return $this->cargoRepository
            ->create($data);
    }

    public function update(
        Cargo $cargo,
        array $data
    ): Cargo {
        return $this->cargoRepository
            ->update($cargo, $data);
    }

    public function delete(
        Cargo $cargo
    ): bool {
        return $this->cargoRepository
            ->delete($cargo);
    }
}