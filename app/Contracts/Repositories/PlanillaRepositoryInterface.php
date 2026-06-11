<?php

namespace App\Contracts\Repositories;

use App\Models\Planilla;
use Illuminate\Database\Eloquent\Collection;

interface PlanillaRepositoryInterface
{
    public function getByPersonaId(int $personaId): Collection;

    public function getByDirectorId(int $directorId): Collection;

    public function findById(int $id): ?Planilla;

    public function create(array $data): Planilla;

    public function update(Planilla $planilla, array $data): Planilla;

    public function delete(Planilla $planilla): bool;
}
