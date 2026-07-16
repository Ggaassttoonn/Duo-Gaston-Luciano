<?php

namespace App\Repositories;

use App\Models\Planilla;
use App\Models\PlanillaDestinatario;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\PlanillaRepositoryInterface;

class PlanillaRepository implements PlanillaRepositoryInterface
{
    public function getByUserId(int $userId, ?string $search = null, ?int $directorId = null): Collection
    {
        $query = Planilla::with('destinatarios.director')
            ->where('user_id', $userId);

        if ($directorId !== null) {
            $query->whereHas('destinatarios', function ($q) use ($directorId) {
                $q->where('director_id', $directorId);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('contenido', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getByDirectorId(int $directorId, ?string $search = null, ?int $docenteId = null): Collection
    {
        $planillaIds = PlanillaDestinatario::where('director_id', $directorId)
            ->pluck('planilla_id')
            ->unique();

        $query = Planilla::with('destinatarios.director', 'user')
            ->whereIn('id', $planillaIds);

        if ($docenteId !== null) {
            $query->where('user_id', $docenteId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('contenido', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function findById(int $id): ?Planilla
    {
        return Planilla::with('destinatarios.director', 'user')->find($id);
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
