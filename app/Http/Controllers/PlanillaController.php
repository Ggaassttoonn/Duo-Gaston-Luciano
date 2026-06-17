<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\PlanillaServiceInterface;
use App\Http\Requests\Planilla\StorePlanillaRequest;
use App\Http\Requests\Planilla\StoreRevisionRequest;
use App\Http\Requests\Planilla\UpdatePlanillaRequest;
use App\Http\Resources\PlanillaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanillaController extends Controller
{
    public function __construct(
        private PlanillaServiceInterface $planillaService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $personaId = $request->query('persona_id');

        if (!$personaId) {
            return response()->json(['message' => 'persona_id es requerido.'], 400);
        }

        $planillas = $this->planillaService->getByPersonaId($personaId);

        return PlanillaResource::collection($planillas)->response();
    }

    public function store(StorePlanillaRequest $request): JsonResponse
    {
        $planilla = $this->planillaService->create($request->validated());

        return response()->json(PlanillaResource::make($planilla), 201);
    }

    public function update(UpdatePlanillaRequest $request, int $id): JsonResponse
    {
        $planilla = $this->planillaService->update($id, $request->validated());

        return response()->json(PlanillaResource::make($planilla));
    }

    public function recibidas(Request $request): JsonResponse
    {
        $user = $request->user();

        $planillas = $this->planillaService->getRecibidas($user->id);

        return PlanillaResource::collection($planillas)->response();
    }

    public function revision(StoreRevisionRequest $request, int $id): JsonResponse
    {
        $user = $request->user();

        $planilla = $this->planillaService->revisar($id, $request->validated(), $user->id);

        return response()->json(PlanillaResource::make($planilla));
    }
}
