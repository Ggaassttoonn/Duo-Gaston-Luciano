<?php

namespace App\Http\Controllers;

use App\Models\PlanificacionDiaria;
use App\Http\Requests\PlanificacionDiaria\StorePlanificacionDiariaRequest;
use App\Http\Requests\PlanificacionDiaria\UpdatePlanificacionDiariaRequest;
use App\Http\Resources\PlanificacionDiariaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Contracts\Interfaces\PlanificacionDiariaServiceInterface;

class PlanificacionDiariaController extends Controller
{
    public function __construct(
        private PlanificacionDiariaServiceInterface $planificacionDiariaService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $user = $request->user();
        $personaCargoCursadoIds = $this->getPersonaCargoCursadoIds($user);
        $planificaciones = $this->planificacionDiariaService->getAllPaginated(15, $search, $personaCargoCursadoIds);
        return PlanificacionDiariaResource::collection($planificaciones)->response();
    }

    public function show(PlanificacionDiaria $planificacionDiaria): JsonResponse
    {
        $planificacionResuelta = $this->planificacionDiariaService->getById($planificacionDiaria);
        return response()->json(PlanificacionDiariaResource::make($planificacionResuelta));
    }

    public function store(StorePlanificacionDiariaRequest $request): JsonResponse
    {
        $planificacion = $this->planificacionDiariaService->create($request->validated());

        return response()->json(PlanificacionDiariaResource::make($planificacion), 201);
    }

    public function update(UpdatePlanificacionDiariaRequest $request, PlanificacionDiaria $planificacionDiaria): JsonResponse
    {
        $planificacionActualizada = $this->planificacionDiariaService->update($planificacionDiaria, $request->validated());

        return response()->json(PlanificacionDiariaResource::make($planificacionActualizada));
    }

    public function destroy(PlanificacionDiaria $planificacionDiaria): JsonResponse
    {
        $this->planificacionDiariaService->delete($planificacionDiaria);
        return response()->json(['message' => 'Planificación diaria eliminada exitosamente']);
    }

    private function getPersonaCargoCursadoIds($user): ?array
    {
        if (!$user->persona) {
            return [];
        }

        return $user->persona
            ->cargos()
            ->with('personaCargoCursados')
            ->get()
            ->pluck('personaCargoCursados')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->values()
            ->toArray();
    }
}
