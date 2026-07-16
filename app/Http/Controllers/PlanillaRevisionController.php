<?php

namespace App\Http\Controllers;

use App\Models\PlanillaRevision;
use App\Models\Planilla;
use App\Models\Notification;
use App\Http\Resources\PlanillaRevisionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanillaRevisionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $revisions = PlanillaRevision::where('director_id', $request->user()->id)
            ->with('planilla')
            ->get();

        return PlanillaRevisionResource::collection($revisions)->response();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'planilla_id' => 'required|integer|exists:planillas,id',
            'estado' => 'required|string',
            'comentario' => 'nullable|string',
            'audio_base64' => 'nullable|string',
            'audio_mime' => 'nullable|string',
            'planilla_original_id' => 'nullable|integer',
        ]);

        $data['director_id'] = $request->user()->id;

        $revision = PlanillaRevision::updateOrCreate(
            ['planilla_id' => $data['planilla_id'], 'director_id' => $data['director_id']],
            $data
        );

        $revision->load('director');

        $planilla = Planilla::find($data['planilla_id']);
        if ($planilla) {
            $planilla->estado = $data['estado'];
            $planilla->save();

            $notificationData = [];
            if (!empty($revision->audio_base64)) {
                $notificationData['audio_base64'] = $revision->audio_base64;
                $notificationData['audio_mime'] = $revision->audio_mime ?? 'audio/webm';
            }

            Notification::create([
                'user_id' => $planilla->user_id,
                'type' => 'planilla_' . $data['estado'],
                'title' => 'Planilla ' . ucfirst($data['estado']),
                'message' => "Tu planilla \"{$planilla->titulo}\" fue {$data['estado']}.",
                'planilla_id' => $planilla->id,
                'data' => $notificationData,
            ]);
        }

        return response()->json(PlanillaRevisionResource::make($revision), 201);
    }
}
