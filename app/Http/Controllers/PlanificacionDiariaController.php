<?php

namespace App\Http\Controllers;

use App\Models\PlanificacionDiaria;
use App\Http\Requests\PlanificacionDiaria\StorePlanificacionDiariaRequest;
use App\Http\Requests\PlanificacionDiaria\UpdatePlanificacionDiariaRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\PlanificacionDiariaServiceInterface;

class PlanificacionDiariaController extends Controller
{
    public function __construct(
        private PlanificacionDiariaServiceInterface $planificacionDiariaService
    ) {}

    public function index(): JsonResponse
    {
        $planificaciones = $this->planificacionDiariaService->getAllPaginated();
        return response()->json($planificaciones);
    }

    public function show(PlanificacionDiaria $planificacionDiaria): JsonResponse
    {
        $planificacionResuelta = $this->planificacionDiariaService->getById($planificacionDiaria);
        return response()->json($planificacionResuelta);
    }

    public function create(): JsonResponse
    {
        $options = $this->planificacionDiariaService->getSelectOptions();
        return response()->json($options);
    }

    public function store(StorePlanificacionDiariaRequest $request): JsonResponse
    {
        $planificacion = $this->planificacionDiariaService->create($request->validated());

        return response()->json([
            'message' => 'Planificación diaria creada exitosamente',
            'data' => $planificacion
        ], 201);
    }

    public function edit(PlanificacionDiaria $planificacionDiaria): JsonResponse
    {
        $options = $this->planificacionDiariaService->getSelectOptions();
        return response()->json(compact('planificacionDiaria') + $options);
    }

    public function update(UpdatePlanificacionDiariaRequest $request, PlanificacionDiaria $planificacionDiaria): JsonResponse
    {
        $planificacionActualizada = $this->planificacionDiariaService->update($planificacionDiaria, $request->validated());

        return response()->json([
            'message' => 'Planificación diaria actualizada exitosamente',
            'data' => $planificacionActualizada
        ]);
    }

    public function destroy(PlanificacionDiaria $planificacionDiaria): JsonResponse
    {
        $this->planificacionDiariaService->delete($planificacionDiaria);
        return response()->json(['message' => 'Planificación diaria eliminada exitosamente']);
    }
}
