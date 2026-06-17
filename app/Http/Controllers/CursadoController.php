<?php

namespace App\Http\Controllers;

use App\Models\Cursado;
use App\Services\CursadoService;
use App\Http\Requests\Cursado\StoreCursadoRequest;
use App\Http\Requests\Cursado\UpdateCursadoRequest;
use App\Http\Resources\CursadoResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\CursadoServiceInterface;



class CursadoController extends Controller
{
    // Usamos inyección de dependencias en el constructor
    public function __construct(private CursadoService $cursadoService)
    {
    }

    public function index(): JsonResponse
    {
        $cursados = $this->cursadoService->getAllPaginated();
        return CursadoResource::collection($cursados)->response();
    }

    public function show(Cursado $cursado): JsonResponse
    {
        $cursadoResuelto = $this->cursadoService->getById($cursado);
        return response()->json(CursadoResource::make($cursadoResuelto));
    }

    public function store(StoreCursadoRequest $request): JsonResponse
    {
        $cursado = $this->cursadoService->create($request->validated());
        
        return response()->json(CursadoResource::make($cursado), 201);
    }

    public function update(UpdateCursadoRequest $request, Cursado $cursado): JsonResponse
    {
        $cursadoActualizado = $this->cursadoService->update($cursado, $request->validated());
        
        return response()->json(CursadoResource::make($cursadoActualizado));
    }

    public function destroy(Cursado $cursado): JsonResponse
    {
        $this->cursadoService->delete($cursado);
        return response()->json(['message' => 'Cursado eliminado exitosamente']);
    }

}