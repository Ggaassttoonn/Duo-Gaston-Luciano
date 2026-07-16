<?php

namespace App\Http\Controllers;

use App\Models\EstadoDiaria;
use App\Models\Notification;
use App\Http\Requests\EstadoDiaria\StoreEstadoDiariaRequest;
use App\Http\Requests\EstadoDiaria\UpdateEstadoDiariaRequest;
use App\Http\Resources\EstadoDiariaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Contracts\Interfaces\EstadoDiariaServiceInterface;

class EstadoDiariaController extends Controller
{
    public function __construct(private EstadoDiariaServiceInterface $estadoDiariaService)
    {
    }

    public function index(): JsonResponse
    {
        $estados = $this->estadoDiariaService->getAllPaginated();
        return EstadoDiariaResource::collection($estados)->response();
    }

    public function show(EstadoDiaria $estadoDiaria): JsonResponse
    {
        $estadoDiariaResuelto = $this->estadoDiariaService->getById($estadoDiaria);
        return response()->json(EstadoDiariaResource::make($estadoDiariaResuelto));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'estado'                  => 'required|string|max:100',
            'fecha'                   => 'required|date',
            'planificacion_diaria_id' => 'required|exists:planificacion_diaria,id',
        ]);

        $estado = $this->estadoDiariaService->create($data);

        $planificacion = \App\Models\PlanificacionDiaria::with('personaCargoCursado.personaCargo.persona')->find($data['planificacion_diaria_id']);

        if ($planificacion && $planificacion->personaCargoCursado) {
            $docenteUser = \App\Models\Users::where('persona_id', $planificacion->personaCargoCursado->personaCargo->persona->id)->first();

            if ($docenteUser) {
                $estadoLabel = $data['estado'];
                Notification::create([
                    'user_id' => $docenteUser->id,
                    'type' => 'planificacion_diaria_estado',
                    'title' => 'Estado de planificación diaria actualizado',
                    'message' => "Tu planificación diaria fue: {$estadoLabel}",
                    'data' => [
                        'planificacion_diaria_id' => $data['planificacion_diaria_id'],
                        'estado' => $estadoLabel,
                    ],
                ]);
            }
        }

        return response()->json(EstadoDiariaResource::make($estado), 201);
    }

    public function update(UpdateEstadoDiariaRequest $request, EstadoDiaria $estadoDiaria): JsonResponse
    {
        $estadoActualizado = $this->estadoDiariaService->update($estadoDiaria, $request->validated());
        
        return response()->json(EstadoDiariaResource::make($estadoActualizado));
    }

    public function destroy(EstadoDiaria $estadoDiaria): JsonResponse
    {
        $this->estadoDiariaService->delete($estadoDiaria);

        return response()->json(null, 204);
    }

}