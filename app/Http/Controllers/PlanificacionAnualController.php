<?php

namespace App\Http\Controllers;

use App\Models\PlanificacionAnual;
use App\Http\Requests\PlanificacionAnual\StorePlanificacionAnualRequest;
use App\Http\Requests\PlanificacionAnual\UpdatePlanificacionAnualRequest;
use App\Http\Resources\PlanificacionAnualResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\PlanificacionAnualServiceInterface;

class PlanificacionAnualController extends Controller
{
    public function __construct(
        private PlanificacionAnualServiceInterface $planificacionAnualService
    ) {}

    public function index(): JsonResponse
    {
        $planificaciones = $this->planificacionAnualService->getAllPaginated();
        return PlanificacionAnualResource::collection($planificaciones)->response();
    }

    public function show(PlanificacionAnual $planificacionAnual): JsonResponse
    {
        $planificacionResuelta = $this->planificacionAnualService->getById($planificacionAnual);
        return response()->json(PlanificacionAnualResource::make($planificacionResuelta));
    }

    public function store(StorePlanificacionAnualRequest $request): JsonResponse
    {
        $planificacion = $this->planificacionAnualService->create($request->validated());

        return response()->json(PlanificacionAnualResource::make($planificacion), 201);
    }

    public function update(UpdatePlanificacionAnualRequest $request, PlanificacionAnual $planificacionAnual): JsonResponse
    {
        $planificacionActualizada = $this->planificacionAnualService->update($planificacionAnual, $request->validated());

        return response()->json(PlanificacionAnualResource::make($planificacionActualizada));
    }

    public function destroy(PlanificacionAnual $planificacionAnual): JsonResponse
    {
        $this->planificacionAnualService->delete($planificacionAnual);
        return response()->json(['message' => 'Planificación anual eliminada exitosamente']);
    }
}
