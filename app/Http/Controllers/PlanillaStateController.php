<?php

namespace App\Http\Controllers;

use App\Models\Planilla;
use App\Models\PlanillaState;
use App\Models\Notification;
use App\Http\Resources\PlanillaStateResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanillaStateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $states = PlanillaState::where('user_id', $request->user()->id)->get();

        return PlanillaStateResource::collection($states)->response();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'planilla_id' => 'required|integer|exists:planillas,id',
            'estado' => 'required|string',
            'comentario' => 'nullable|string',
            'audio' => 'nullable|string',
        ]);

        $data['user_id'] = $request->user()->id;

        $state = PlanillaState::updateOrCreate(
            ['planilla_id' => $data['planilla_id'], 'user_id' => $data['user_id']],
            ['estado' => $data['estado']]
        );

        $planilla = Planilla::find($data['planilla_id']);
        if ($planilla) {
            $planilla->estado = $data['estado'];
            $planilla->save();

            $notificationData = [];
            if (!empty($data['audio'])) {
                $notificationData['audio'] = $data['audio'];
            }
            if (!empty($data['comentario'])) {
                $notificationData['comentario'] = $data['comentario'];
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

        return response()->json(PlanillaStateResource::make($state), 201);
    }
}
