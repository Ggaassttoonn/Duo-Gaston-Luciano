<?php

namespace App\Repositories;

use App\Models\PlanillaState;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\PlanillaStateRepositoryInterface;

class PlanillaStateRepository implements PlanillaStateRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return PlanillaState::paginate($perPage);
    }

    public function getById(
        PlanillaState $planillaState
    ): PlanillaState {
        return $planillaState;
    }

    public function create(
        array $data
    ): PlanillaState {
        return PlanillaState::create($data);
    }

    public function update(
        PlanillaState $planillaState,
        array $data
    ): PlanillaState {
        $planillaState->update($data);

        return $planillaState;
    }

    public function delete(
        PlanillaState $planillaState
    ): bool {
        return $planillaState->delete();
    }
}
