<?php

namespace App\Contracts\Repositories;

use App\Models\PlanillaDestinatario;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanillaDestinatarioRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        PlanillaDestinatario $planillaDestinatario
    ): PlanillaDestinatario;

    public function create(
        array $data
    ): PlanillaDestinatario;

    public function update(
        PlanillaDestinatario $planillaDestinatario,
        array $data
    ): PlanillaDestinatario;

    public function delete(
        PlanillaDestinatario $planillaDestinatario
    ): bool;
}
