<?php

namespace App\Repositories;

use App\Models\PlanillaDestinatario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\PlanillaDestinatarioRepositoryInterface;

class PlanillaDestinatarioRepository implements PlanillaDestinatarioRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return PlanillaDestinatario::paginate($perPage);
    }

    public function getById(
        PlanillaDestinatario $planillaDestinatario
    ): PlanillaDestinatario {
        return $planillaDestinatario;
    }

    public function create(
        array $data
    ): PlanillaDestinatario {
        return PlanillaDestinatario::create($data);
    }

    public function update(
        PlanillaDestinatario $planillaDestinatario,
        array $data
    ): PlanillaDestinatario {
        $planillaDestinatario->update($data);

        return $planillaDestinatario;
    }

    public function delete(
        PlanillaDestinatario $planillaDestinatario
    ): bool {
        return $planillaDestinatario->delete();
    }
}
