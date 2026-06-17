<?php

namespace App\Contracts\Repositories;

use App\Models\PlanillaRevision;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanillaRevisionRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        PlanillaRevision $planillaRevision
    ): PlanillaRevision;

    public function create(
        array $data
    ): PlanillaRevision;

    public function update(
        PlanillaRevision $planillaRevision,
        array $data
    ): PlanillaRevision;

    public function delete(
        PlanillaRevision $planillaRevision
    ): bool;
}
