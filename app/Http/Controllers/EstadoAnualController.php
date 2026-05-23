<?php

namespace App\Http\Controllers;

use App\Models\EstadoAnual;
use App\Services\EstadoAnualService;
use App\Http\Requests\EstadoAnual\StoreEstadoAnualRequest;
use App\Http\Requests\EstadoAnual\UpdateEstadoAnualRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\EstadoAnualServiceInterface;

class EstadoAnualController extends Controller
{
    public function __construct(private EstadoAnualService $estadoAnualService)
    {
    }

    public function index(): JsonResponse
    {
        $estados = $this->estadoAnualService->getAllPaginated();
        return response()->json($estados);
    }

    public function show(EstadoAnual $estadoAnual): JsonResponse
    {
        $estadoAnualResuelto = $this->estadoAnualService->getById($estadoAnual);
        return response()->json($estadoAnualResuelto);
    }

    public function create(): JsonResponse
    {
        $options = $this->estadoAnualService->getSelectOptions();
        return response()->json($options);
    }

    // Inyectamos StoreEstadoAnualRequest para validar automáticamente
    public function store(StoreEstadoAnualRequest $request): JsonResponse
    {
        $estado = $this->estadoAnualService->create($request->validated());
        
        return response()->json([
            'message' => 'Estado anual creado exitosamente',
            'data' => $estado
        ], 201);
    }

    public function edit(EstadoAnual $estadoAnual): JsonResponse
    {
        $options = $this->estadoAnualService->getSelectOptions();
        return response()->json(compact('estadoAnual') + $options);
    }

    // Inyectamos UpdateEstadoAnualRequest para la edición
    public function update(UpdateEstadoAnualRequest $request, EstadoAnual $estadoAnual): JsonResponse
    {
        $estadoActualizado = $this->estadoAnualService->update($estadoAnual, $request->validated());
        
        return response()->json([
            'message' => 'Estado anual actualizado exitosamente',
            'data' => $estadoActualizado
        ]);
    }

    public function destroy(EstadoAnual $estadoAnual): JsonResponse
    {
        $this->estadoAnualService->delete($estadoAnual);
        return response()->json(['message' => 'Estado anual eliminado exitosamente']);
    }
   
    private EstadoAnualServiceInterface $estadoAnualService
 {
}
}