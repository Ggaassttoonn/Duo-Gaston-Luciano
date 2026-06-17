<?php

namespace App\Http\Controllers;

use App\Models\EstadoDiaria;
use App\Services\EstadoDiariaService;
use App\Http\Requests\EstadoDiaria\StoreEstadoDiariaRequest;
use App\Http\Requests\EstadoDiaria\UpdateEstadoDiariaRequest;
use App\Http\Resources\EstadoDiariaResource;
use Illuminate\Http\JsonResponse;
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

    public function store(StoreEstadoDiariaRequest $request): JsonResponse
    {
        $estado = $this->estadoDiariaService->create($request->validated());
        
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
        return response()->json(['message' => 'Estado diario eliminado exitosamente']);
    }
    
}