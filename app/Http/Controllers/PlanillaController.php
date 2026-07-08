<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\PlanillaServiceInterface;
use App\Http\Requests\Planilla\StorePlanillaRequest;
use App\Http\Requests\Planilla\StoreRevisionRequest;
use App\Http\Requests\Planilla\UpdatePlanillaRequest;
use App\Http\Resources\PlanillaResource;
use App\Models\Planilla;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanillaController extends Controller
{
    public function __construct(
        private PlanillaServiceInterface $planillaService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $userId = $request->query('user_id');
        $search = $request->query('search');

        if (!$userId) {
            return response()->json(['message' => 'user_id es requerido.'], 400);
        }

        $currentUser = $request->user();
        $directorId = $currentUser->role === 'director' ? $currentUser->id : null;

        $planillas = $this->planillaService->getByUserId($userId, $search, $directorId);

        return PlanillaResource::collection($planillas)->response();
    }

    public function store(StorePlanillaRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $planilla = $this->planillaService->create($data);

        return response()->json(PlanillaResource::make($planilla), 201);
    }

    public function update(UpdatePlanillaRequest $request, Planilla $planilla): JsonResponse
    {
        $planilla = $this->planillaService->update($planilla->id, $request->validated());

        return response()->json(PlanillaResource::make($planilla));
    }

    public function recibidas(Request $request): JsonResponse
    {
        $user = $request->user();
        $search = $request->query('search');
        $docenteId = $request->query('docente_id');

        $planillas = $this->planillaService->getRecibidas($user->id, $search, $docenteId);

        return PlanillaResource::collection($planillas)->response();
    }

    public function destroy(Request $request, Planilla $planilla): JsonResponse
    {
        $user = $request->user();

        $this->planillaService->delete($planilla->id, $user->id);

        return response()->json(['message' => 'Planilla eliminada exitosamente.']);
    }

    public function revision(StoreRevisionRequest $request, Planilla $planilla): JsonResponse
    {
        $user = $request->user();

        $planilla = $this->planillaService->revisar($planilla->id, $request->validated(), $user->id);

        return response()->json(PlanillaResource::make($planilla));
    }
}
