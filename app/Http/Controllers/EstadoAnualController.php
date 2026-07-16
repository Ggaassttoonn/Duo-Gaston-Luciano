<?php

namespace App\Http\Controllers;

use App\Models\EstadoAnual;
use App\Models\Notification;
use App\Http\Requests\EstadoAnual\StoreEstadoAnualRequest;
use App\Http\Requests\EstadoAnual\UpdateEstadoAnualRequest;
use App\Http\Resources\EstadoAnualResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Contracts\Interfaces\EstadoAnualServiceInterface;

class EstadoAnualController extends Controller
{
    public function __construct(private EstadoAnualServiceInterface $estadoAnualService)
    {
    }

    public function index(): JsonResponse
    {
        $estados = $this->estadoAnualService->getAllPaginated();
        return EstadoAnualResource::collection($estados)->response();
    }

    public function show(EstadoAnual $estadoAnual): JsonResponse
    {
        $estadoAnualResuelto = $this->estadoAnualService->getById($estadoAnual);
        return response()->json(EstadoAnualResource::make($estadoAnualResuelto));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'estado'                 => 'required|string|max:100',
            'fecha'                  => 'required|date',
            'planificacion_anual_id' => 'required|exists:planificacion_anual,id',
        ]);

        $estado = $this->estadoAnualService->create($data);

        $planificacion = \App\Models\PlanificacionAnual::with('personaCargoCursado.personaCargo.persona')->find($data['planificacion_anual_id']);

        if ($planificacion && $planificacion->personaCargoCursado) {
            $docenteUser = \App\Models\Users::where('persona_id', $planificacion->personaCargoCursado->personaCargo->persona->id)->first();

            if ($docenteUser) {
                $estadoLabel = $data['estado'];
                Notification::create([
                    'user_id' => $docenteUser->id,
                    'type' => 'planificacion_anual_estado',
                    'title' => 'Estado de planificación anual actualizado',
                    'message' => "Tu planificación anual fue: {$estadoLabel}",
                    'data' => [
                        'planificacion_anual_id' => $data['planificacion_anual_id'],
                        'estado' => $estadoLabel,
                    ],
                ]);
            }
        }

        return response()->json(EstadoAnualResource::make($estado), 201);
    }

    public function update(UpdateEstadoAnualRequest $request, EstadoAnual $estadoAnual): JsonResponse
    {
        $estadoActualizado = $this->estadoAnualService->update($estadoAnual, $request->validated());
        
        return response()->json(EstadoAnualResource::make($estadoActualizado));
    }

    public function destroy(EstadoAnual $estadoAnual): JsonResponse
    {
        $this->estadoAnualService->delete($estadoAnual);

        return response()->json(null, 204);
    }
}