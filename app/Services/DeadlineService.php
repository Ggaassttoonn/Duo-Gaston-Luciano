<?php

namespace App\Services;

use App\Contracts\Interfaces\DeadlineServiceInterface;
use App\Models\Assignment;
use App\Models\Deadline;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DeadlineService implements DeadlineServiceInterface
{
    public function getAll(): Collection
    {
        return Deadline::with([
            'director',
            'assignments.user',
        ])
            ->orderBy('fecha_limite', 'desc')
            ->get();
    }

    public function getById(Deadline $deadline): Deadline
    {
        return $deadline->load([
            'director',
            'assignments.user',
        ]);
    }

    public function create(array $data): Deadline
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'director'])) {
            throw ValidationException::withMessages([
                'message' => ['Solo el director puede crear plazos.'],
            ]);
        }

        $deadline = Deadline::create([
            'director_id' => $user->id,
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'fecha_limite' => $data['fecha_limite'],
        ]);

        foreach ($data['user_ids'] as $userId) {
            Assignment::create([
                'deadline_id' => $deadline->id,
                'user_id' => $userId,
                'status' => 'pending',
            ]);
        }

        return $deadline->load([
            'director',
            'assignments.user',
        ]);
    }

    public function update(Deadline $deadline, array $data): Deadline
    {
        $deadline->update([
            'titulo' => $data['titulo'] ?? $deadline->titulo,
            'descripcion' => array_key_exists('descripcion', $data) ? $data['descripcion'] : $deadline->descripcion,
            'fecha_limite' => $data['fecha_limite'] ?? $deadline->fecha_limite,
        ]);

        if (isset($data['user_ids'])) {
            $existingUserIds = $deadline->assignments()->pluck('user_id')->toArray();

            $toAdd = array_diff($data['user_ids'], $existingUserIds);
            $toRemove = array_diff($existingUserIds, $data['user_ids']);

            foreach ($toAdd as $userId) {
                Assignment::create([
                    'deadline_id' => $deadline->id,
                    'user_id' => $userId,
                    'status' => 'pending',
                ]);
            }

            if (!empty($toRemove)) {
                $deadline->assignments()->whereIn('user_id', $toRemove)->delete();
            }
        }

        return $deadline->load([
            'director',
            'assignments.user',
        ]);
    }

    public function delete(Deadline $deadline): bool
    {
        return $deadline->delete();
    }
}
