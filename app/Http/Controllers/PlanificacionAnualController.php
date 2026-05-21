<?php

namespace App\Http\Controllers;

use App\Models\PlanificacionAnual;
use App\Http\Requests\StorePlanificacionAnualRequest;
use App\Http\Requests\UpdatePlanificacionAnualRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\PlanificacionAnualServiceInterface;

class PlanificacionAnualController extends Controller
{
    public function __construct(
        private PlanificacionAnualServiceInterface $planificacionAnualService
    ) {}

    public function index(): JsonResponse
    {
        $planificaciones = $this->planificacionAnualService->getAllPaginated();
        return response()->json($planificaciones);
    }

    public function show(PlanificacionAnual $planificacionAnual): JsonResponse
    {
        $planificacionResuelta = $this->planificacionAnualService->getById($planificacionAnual);
        return response()->json($planificacionResuelta);
    }

    public function create(): JsonResponse
    {
        $options = $this->planificacionAnualService->getSelectOptions();
        return response()->json($options);
    }

    public function store(StorePlanificacionAnualRequest $request): JsonResponse
    {
        $planificacion = $this->planificacionAnualService->create($request->validated());

        return response()->json([
            'message' => 'Planificación anual creada exitosamente',
            'data' => $planificacion
        ], 201);
    }

    public function edit(PlanificacionAnual $planificacionAnual): JsonResponse
    {
        $options = $this->planificacionAnualService->getSelectOptions();
        return response()->json(compact('planificacionAnual') + $options);
    }

    public function update(UpdatePlanificacionAnualRequest $request, PlanificacionAnual $planificacionAnual): JsonResponse
    {
        $planificacionActualizada = $this->planificacionAnualService->update($planificacionAnual, $request->validated());

        return response()->json([
            'message' => 'Planificación anual actualizada exitosamente',
            'data' => $planificacionActualizada
        ]);
    }

    public function destroy(PlanificacionAnual $planificacionAnual): JsonResponse
    {
        $this->planificacionAnualService->delete($planificacionAnual);
        return response()->json(['message' => 'Planificación anual eliminada exitosamente']);
    }
}
