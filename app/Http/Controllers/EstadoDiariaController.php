<?php

namespace App\Http\Controllers;

use App\Models\EstadoDiaria;
use App\Services\EstadoDiariaService;
use App\Http\Requests\EstadoDiaria\StoreEstadoDiariaRequest;
use App\Http\Requests\EstadoDiaria\UpdateEstadoDiariaRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\EstadoDiariaServiceInterface;
class EstadoDiariaController extends Controller
{
    public function __construct(private EstadoDiariaService $estadoDiariaService)
    {
    }

    public function index(): JsonResponse
    {
        $estados = $this->estadoDiariaService->getAllPaginated();
        return response()->json($estados);
    }

    public function show(EstadoDiaria $estadoDiaria): JsonResponse
    {
        $estadoDiariaResuelto = $this->estadoDiariaService->getById($estadoDiaria);
        return response()->json($estadoDiariaResuelto);
    }

    public function create(): JsonResponse
    {
        $options = $this->estadoDiariaService->getSelectOptions();
        return response()->json($options);
    }

    // Inyectamos StoreEstadoDiariaRequest para interceptar y validar la petición
    public function store(StoreEstadoDiariaRequest $request): JsonResponse
    {
        $estado = $this->estadoDiariaService->create($request->validated());
        
        return response()->json([
            'message' => 'Estado diario creado exitosamente',
            'data' => $estado
        ], 201);
    }

    public function edit(EstadoDiaria $estadoDiaria): JsonResponse
    {
        $options = $this->estadoDiariaService->getSelectOptions();
        return response()->json(compact('estadoDiaria') + $options);
    }

    // Inyectamos UpdateEstadoDiariaRequest para la actualización parcial o total
    public function update(UpdateEstadoDiariaRequest $request, EstadoDiaria $estadoDiaria): JsonResponse
    {
        $estadoActualizado = $this->estadoDiariaService->update($estadoDiaria, $request->validated());
        
        return response()->json([
            'message' => 'Estado diario actualizado exitosamente',
            'data' => $estadoActualizado
        ]);
    }

    public function destroy(EstadoDiaria $estadoDiaria): JsonResponse
    {
        $this->estadoDiariaService->delete($estadoDiaria);
        return response()->json(['message' => 'Estado diario eliminado exitosamente']);
    }
    
    private EstadoDiariaServiceInterface $estadoDiariaService
 {
}
}