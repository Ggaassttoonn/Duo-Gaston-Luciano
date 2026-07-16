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
use Illuminate\Support\Facades\DB;

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

    private function normalizePlanillaData(array $data): array
    {
        if (empty($data['titulo']) && !empty($data['title'])) {
            $data['titulo'] = $data['title'];
        }
        if (empty($data['contenido']) && !empty($data['content'])) {
            $data['contenido'] = $data['content'];
        }
        unset($data['title'], $data['content']);
        return $data;
    }

    public function store(StorePlanillaRequest $request): JsonResponse
    {
        try {
            $data = $this->normalizePlanillaData($request->validated());
            $data['user_id'] = $request->user()->id;

            $planilla = $this->planillaService->create($data);

            return response()->json(PlanillaResource::make($planilla), 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error al crear planilla.',
                'error' => $e->getMessage(),
                'file' => basename($e->getFile()) . ':' . $e->getLine(),
            ], 500);
        }
    }

    public function update(UpdatePlanillaRequest $request, Planilla $planilla): JsonResponse
    {
        try {
            $data = $this->normalizePlanillaData($request->validated());
            $planilla = $this->planillaService->update($planilla->id, $data);

            return response()->json(PlanillaResource::make($planilla));
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error al actualizar planilla.',
                'error' => $e->getMessage(),
                'file' => basename($e->getFile()) . ':' . $e->getLine(),
            ], 500);
        }
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

    public function stats(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $counts = Planilla::where('user_id', $userId)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        return response()->json([
            'aprobadas' => $counts->get('aprobado', 0),
            'en_revision' => $counts->get('revisado', 0) + $counts->get('pendiente', 0),
            'rechazadas' => $counts->get('rechazado', 0),
            'borrador' => $counts->get('borrador', 0),
            'total' => $counts->sum(),
        ]);
    }
}
