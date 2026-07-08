<?php

namespace App\Contracts\Interfaces;

use App\Models\Planilla;
use Illuminate\Database\Eloquent\Collection;

interface PlanillaServiceInterface
{
    public function getByUserId(int $userId, ?string $search = null, ?int $directorId = null): Collection;

    public function getRecibidas(int $directorId, ?string $search = null, ?int $docenteId = null): Collection;

    public function create(array $data): Planilla;

    public function update(int $id, array $data): Planilla;

    public function revisar(int $id, array $data, int $directorId): Planilla;

    public function delete(int $id, int $userId): void;
}
