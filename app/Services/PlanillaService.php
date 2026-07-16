<?php

namespace App\Services;

use App\Models\Planilla;
use App\Models\PlanillaDestinatario;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Contracts\Interfaces\PlanillaServiceInterface;
use App\Contracts\Repositories\PlanillaRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Validation\ValidationException;

class PlanillaService implements PlanillaServiceInterface
{
    public function __construct(
        private PlanillaRepositoryInterface $planillaRepository
    ) {}

    public function getByUserId(int $userId, ?string $search = null, ?int $directorId = null): Collection
    {
        return $this->planillaRepository->getByUserId($userId, $search, $directorId);
    }

    public function getRecibidas(int $directorId, ?string $search = null, ?int $docenteId = null): Collection
    {
        return $this->planillaRepository->getByDirectorId($directorId, $search, $docenteId);
    }

    public function create(array $data): Planilla
    {
        return DB::transaction(function () use ($data) {
            $data['estado'] = 'borrador';

            $planilla = $this->planillaRepository->create($data);

            if (isset($data['directores']) && is_array($data['directores'])) {
                foreach ($data['directores'] as $directorId) {
                    PlanillaDestinatario::create([
                        'planilla_id' => $planilla->id,
                        'director_id' => $directorId,
                    ]);
                    Notification::create([
                        'user_id' => $directorId,
                        'type' => 'planilla_asignada',
                        'title' => 'Nueva planilla asignada',
                        'message' => "Se te ha asignado una nueva planilla: {$planilla->titulo}",
                        'planilla_id' => $planilla->id,
                    ]);
                }
            }

            return $planilla->load('destinatarios.director', 'user');
        });
    }

    public function update(int $id, array $data): Planilla
    {
        return DB::transaction(function () use ($id, $data) {
            $planilla = $this->planillaRepository->findById($id);

            if (!$planilla) {
                throw ValidationException::withMessages([
                    'planilla' => ['Planilla no encontrada.'],
                ]);
            }

            $directores = null;
            if (isset($data['directores'])) {
                $directores = $data['directores'];
                unset($data['directores']);
            }

            $planilla = $this->planillaRepository->update($planilla, $data);

            if ($directores !== null) {
                PlanillaDestinatario::where('planilla_id', $id)->delete();

                foreach ($directores as $directorId) {
                    PlanillaDestinatario::create([
                        'planilla_id' => $planilla->id,
                        'director_id' => $directorId,
                    ]);
                    Notification::create([
                        'user_id' => $directorId,
                        'type' => 'planilla_asignada',
                        'title' => 'Nueva planilla asignada',
                        'message' => "Se te ha asignado una nueva planilla: {$planilla->titulo}",
                        'planilla_id' => $planilla->id,
                    ]);
                }
            }

            return $planilla->load('destinatarios.director', 'user');
        });
    }

    public function delete(int $id, int $userId): void
    {
        $planilla = $this->planillaRepository->findById($id);

        if (!$planilla) {
            throw new NotFoundHttpException('Planilla no encontrada.');
        }

        if ($planilla->user_id !== $userId) {
            throw new AccessDeniedHttpException('No tienes permiso para eliminar esta planilla.');
        }

        $this->planillaRepository->delete($planilla);
    }

    public function revisar(int $id, array $data, int $directorId): Planilla
    {
        return DB::transaction(function () use ($id, $data, $directorId) {
            $planilla = $this->planillaRepository->findById($id);

            if (!$planilla) {
                throw ValidationException::withMessages([
                    'planilla' => ['Planilla no encontrada.'],
                ]);
            }

            $destinatario = PlanillaDestinatario::where('planilla_id', $id)
                ->where('director_id', $directorId)
                ->first();

            if (!$destinatario) {
                throw ValidationException::withMessages([
                    'destinatario' => ['No eres destinatario de esta planilla.'],
                ]);
            }

            if (isset($data['comentario'])) {
                $destinatario->comentario = $data['comentario'];
            }

            if (isset($data['audio'])) {
                $destinatario->audio = $this->saveAudio($data['audio']);
            }

            if (isset($data['estado'])) {
                $planilla->estado = $data['estado'];
                $planilla->save();

                Notification::create([
                    'user_id' => $planilla->user_id,
                    'type' => 'planilla_' . $data['estado'],
                    'title' => 'Planilla ' . ucfirst($data['estado']),
                    'message' => "Tu planilla \"{$planilla->titulo}\" fue {$data['estado']}.",
                    'planilla_id' => $planilla->id,
                ]);
            }

            $destinatario->leido = true;
            $destinatario->save();

            return $planilla->fresh()->load('destinatarios.director', 'user');
        });
    }

    private function saveAudio(string $dataUrl): string
    {
        if (!preg_match('/^data:audio\/(webm|mp3|wav|ogg);base64,/', $dataUrl)) {
            throw ValidationException::withMessages([
                'audio' => ['Formato de audio no válido. Solo se permiten WebM, MP3, WAV y OGG.'],
            ]);
        }

        $audioData = base64_decode(
            preg_replace('/^data:audio\/\w+;base64,/', '', $dataUrl)
        );

        $maxSize = 10 * 1024 * 1024;

        if (strlen($audioData) > $maxSize) {
            throw ValidationException::withMessages([
                'audio' => ['El audio no debe superar los 10 MB.'],
            ]);
        }

        $extension = strtolower(
            preg_replace('/^data:audio\/(\w+);base64,/', '$1', $dataUrl)
        );

        $filename = 'audios/' . uniqid() . '.' . $extension;

        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $audioData);

        return \Illuminate\Support\Facades\Storage::disk('public')->url($filename);
    }
}
