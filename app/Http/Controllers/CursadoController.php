<?php

namespace App\Http\Controllers;

use App\Models\Cursado;
use App\Services\CursadoService;
use App\Http\Requests\StoreCursadoRequest;
use App\Http\Requests\UpdateCursadoRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\CursadoServiceInterface;



class CursadoController extends Controller
{
    // Usamos inyección de dependencias en el constructor
    public function __construct(private CursadoService $cursadoService)
    {
    }

    public function index(): JsonResponse
    {
        $cursados = $this->cursadoService->getAllPaginated();
        return response()->json($cursados);
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function show(Cursado $cursado): JsonResponse
    {
        $cursadoResuelto = $this->cursadoService->getById($cursado);
        return response()->json($cursadoResuelto);
    }

    public function edit(Cursado $cursado): JsonResponse
    {
        return response()->json($cursado);
    }

    // Inyectamos StoreCursadoRequest para validar automáticamente la creación
    public function store(StoreCursadoRequest $request): JsonResponse
    {
        // $request->validated() ya nos da los datos limpios y validados
        $cursado = $this->cursadoService->create($request->validated());
        
        return response()->json([
            'message' => 'Cursado creado exitosamente',
            'data' => $cursado
        ], 201);
    }

    // Inyectamos UpdateCursadoRequest para validar la actualización
    public function update(UpdateCursadoRequest $request, Cursado $cursado): JsonResponse
    {
        $cursadoActualizado = $this->cursadoService->update($cursado, $request->validated());
        
        return response()->json([
            'message' => 'Cursado actualizado exitosamente',
            'data' => $cursadoActualizado
        ]);
    }

    public function destroy(Cursado $cursado): JsonResponse
    {
        $this->cursadoService->delete($cursado);
        return response()->json(['message' => 'Cursado eliminado exitosamente']);
    }

}