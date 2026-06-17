<?php

namespace App\Repositories;

use App\Models\PlanillaRevision;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\PlanillaRevisionRepositoryInterface;

class PlanillaRevisionRepository implements PlanillaRevisionRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return PlanillaRevision::paginate($perPage);
    }

    public function getById(
        PlanillaRevision $planillaRevision
    ): PlanillaRevision {
        return $planillaRevision;
    }

    public function create(
        array $data
    ): PlanillaRevision {
        return PlanillaRevision::create($data);
    }

    public function update(
        PlanillaRevision $planillaRevision,
        array $data
    ): PlanillaRevision {
        $planillaRevision->update($data);

        return $planillaRevision;
    }

    public function delete(
        PlanillaRevision $planillaRevision
    ): bool {
        return $planillaRevision->delete();
    }
}
