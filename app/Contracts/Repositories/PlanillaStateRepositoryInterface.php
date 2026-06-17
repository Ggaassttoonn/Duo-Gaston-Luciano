<?php

namespace App\Contracts\Repositories;

use App\Models\PlanillaState;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanillaStateRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        PlanillaState $planillaState
    ): PlanillaState;

    public function create(
        array $data
    ): PlanillaState;

    public function update(
        PlanillaState $planillaState,
        array $data
    ): PlanillaState;

    public function delete(
        PlanillaState $planillaState
    ): bool;
}
