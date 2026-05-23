<?php

namespace App\Services;

use App\Models\Area;
use App\Contracts\Interfaces\AreaServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\AreaRepositoryInterface;

class AreaService implements AreaServiceInterface
{
    public function __construct(
        private AreaRepositoryInterface $areaRepository
    ) {
    }

    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->areaRepository
            ->getAllPaginated($perPage);
    }

    public function getById(
        Area $area
    ): Area {
        return $this->areaRepository
            ->getById($area);
    }

    public function create(
        array $data
    ): Area {
        return $this->areaRepository
            ->create($data);
    }

    public function update(
        Area $area,
        array $data
    ): Area {
        return $this->areaRepository
            ->update($area, $data);
    }

    public function delete(
        Area $area
    ): bool {
        return $this->areaRepository
            ->delete($area);
    }
}