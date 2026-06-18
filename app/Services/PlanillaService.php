<?php

namespace App\Services;

use App\Models\Planilla;
use App\Models\PlanillaDestinatario;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Contracts\Interfaces\PlanillaServiceInterface;
use App\Contracts\Repositories\PlanillaRepositoryInterface;
use Illuminate\Validation\ValidationException;

class PlanillaService implements PlanillaServiceInterface
{
    public function __construct(
        private PlanillaRepositoryInterface $planillaRepository
    ) {}

    public function getByPersonaId(int $personaId): Collection
    {
        return $this->planillaRepository->getByPersonaId($personaId);
    }

    public function getRecibidas(int $directorId): Collection
    {
        return $this->planillaRepository->getByDirectorId($directorId);
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
                }
            }

            return $planilla->load('destinatarios.director', 'persona');
        });
    }

    public function update(int $id, array $data): Planilla
    {
        $planilla = $this->planillaRepository->findById($id);

        if (!$planilla) {
            throw ValidationException::withMessages([
                'planilla' => ['Planilla no encontrada.'],
            ]);
        }

        $planilla = $this->planillaRepository->update($planilla, $data);

        return $planilla->load('destinatarios.director', 'persona');
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
            }

            $destinatario->leido = true;
            $destinatario->save();

            return $planilla->fresh()->load('destinatarios.director', 'persona');
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
