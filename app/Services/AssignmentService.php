<?php

namespace App\Services;

use App\Contracts\Interfaces\AssignmentServiceInterface;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AssignmentService implements AssignmentServiceInterface
{
    public function getByDeadline(int $deadlineId): Collection
    {
        return Assignment::with('user')
            ->where('deadline_id', $deadlineId)
            ->get();
    }

    public function getMyAssignments(): Collection
    {
        $user = Auth::user();

        return Assignment::with([
            'deadline.director',
        ])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function update(Assignment $assignment, array $data): Assignment
    {
        $user = Auth::user();

        $isDirector = in_array($user->role, ['admin', 'director']);
        $isOwner = $assignment->user_id === $user->id;

        if (!$isDirector && !$isOwner) {
            throw ValidationException::withMessages([
                'message' => ['No tienes permiso para modificar esta entrega.'],
            ]);
        }

        $newStatus = $data['status'];

        if ($newStatus === 'approved' && !$isDirector) {
            throw ValidationException::withMessages([
                'message' => ['Solo el director puede aprobar entregas.'],
            ]);
        }

        if ($isOwner && $newStatus === 'submitted') {
            if ($assignment->status === 'approved') {
                throw ValidationException::withMessages([
                    'message' => ['No puedes modificar una entrega ya aprobada.'],
                ]);
            }

            $assignment->update([
                'status' => 'submitted',
                'respuesta' => $data['respuesta'] ?? $assignment->respuesta,
                'submitted_at' => now(),
            ]);
        } elseif ($isDirector && $newStatus === 'approved') {
            if ($assignment->status !== 'submitted') {
                throw ValidationException::withMessages([
                    'message' => ['Solo se puede aprobar una entrega que esté en estado "submitted".'],
                ]);
            }

            $assignment->update([
                'status' => 'approved',
            ]);
        }

        return $assignment->load(['user', 'deadline.director']);
    }
}
