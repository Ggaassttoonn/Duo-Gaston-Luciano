<?php

namespace App\Repositories;

use App\Models\Planilla;
use App\Models\PlanillaDestinatario;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\PlanillaRepositoryInterface;

class PlanillaRepository implements PlanillaRepositoryInterface
{
    public function getByPersonaId(int $personaId): Collection
    {
        return Planilla::with('destinatarios.director')
            ->where('persona_id', $personaId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByDirectorId(int $directorId): Collection
    {
        return new Collection(
            PlanillaDestinatario::with('planilla.persona')
                ->where('director_id', $directorId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->pluck('planilla')
                ->unique('id')
                ->values()
                ->all()
        );
    }

    public function findById(int $id): ?Planilla
    {
        return Planilla::with('destinatarios.director', 'persona')->find($id);
    }

    public function create(array $data): Planilla
    {
        return Planilla::create($data);
    }

    public function update(Planilla $planilla, array $data): Planilla
    {
        $planilla->update($data);
        return $planilla;
    }

    public function delete(Planilla $planilla): bool
    {
        return $planilla->delete();
    }
}
