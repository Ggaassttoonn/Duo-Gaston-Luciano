<?php

namespace App\Repositories;

use App\Models\Area;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\AreaRepositoryInterface;

class AreaRepository implements AreaRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return Area::paginate($perPage);
    }

    public function getById(
        Area $area
    ): Area {
        return $area->load('planificacionesAnuales');
    }

    public function create(
        array $data
    ): Area {
        return Area::create($data);
    }

    public function update(
        Area $area,
        array $data
    ): Area {
        $area->update($data);

        return $area;
    }

    public function delete(
        Area $area
    ): bool {
        return $area->delete();
    }
}