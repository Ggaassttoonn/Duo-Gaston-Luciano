<?php

namespace App\Contracts\Interfaces;

use App\Models\Planilla;
use Illuminate\Database\Eloquent\Collection;

interface PlanillaServiceInterface
{
    public function getByPersonaId(int $personaId): Collection;

    public function getRecibidas(int $directorId): Collection;

    public function create(array $data): Planilla;

    public function update(int $id, array $data): Planilla;

    public function revisar(int $id, array $data, int $directorId): Planilla;
}
