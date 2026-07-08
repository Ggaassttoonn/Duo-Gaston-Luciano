<?php

namespace App\Contracts\Repositories;

use App\Models\Planilla;
use Illuminate\Database\Eloquent\Collection;

interface PlanillaRepositoryInterface
{
    public function getByUserId(int $userId, ?string $search = null, ?int $directorId = null): Collection;

    public function getByDirectorId(int $directorId, ?string $search = null, ?int $docenteId = null): Collection;

    public function findById(int $id): ?Planilla;

    public function create(array $data): Planilla;

    public function update(Planilla $planilla, array $data): Planilla;

    public function delete(Planilla $planilla): bool;
}
