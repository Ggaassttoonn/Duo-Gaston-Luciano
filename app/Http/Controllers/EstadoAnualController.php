<?php

namespace App\Http\Controllers;

use App\Models\EstadoAnual;
use App\Services\EstadoAnualService;
use App\Http\Requests\EstadoAnual\StoreEstadoAnualRequest;
use App\Http\Requests\EstadoAnual\UpdateEstadoAnualRequest;
use App\Http\Resources\EstadoAnualResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\EstadoAnualServiceInterface;

class EstadoAnualController extends Controller
{
    public function __construct(private EstadoAnualServiceInterface $estadoAnualService)
    {
    }

    public function index(): JsonResponse
    {
        $estados = $this->estadoAnualService->getAllPaginated();
        return EstadoAnualResource::collection($estados)->response();
    }

    public function show(EstadoAnual $estadoAnual): JsonResponse
    {
        $estadoAnualResuelto = $this->estadoAnualService->getById($estadoAnual);
        return response()->json(EstadoAnualResource::make($estadoAnualResuelto));
    }

    public function store(StoreEstadoAnualRequest $request): JsonResponse
    {
        $estado = $this->estadoAnualService->create($request->validated());
        
        return response()->json(EstadoAnualResource::make($estado), 201);
    }

    public function update(UpdateEstadoAnualRequest $request, EstadoAnual $estadoAnual): JsonResponse
    {
        $estadoActualizado = $this->estadoAnualService->update($estadoAnual, $request->validated());
        
        return response()->json(EstadoAnualResource::make($estadoActualizado));
    }

    public function destroy(EstadoAnual $estadoAnual): JsonResponse
    {
        $this->estadoAnualService->delete($estadoAnual);
        return response()->json(['message' => 'Estado anual eliminado exitosamente']);
    }
   
}