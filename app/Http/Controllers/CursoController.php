<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\JsonResponse;
use App\Services\CursoService;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Contracts\CursoServiceInterface;
class CursoController extends Controller
{
    public function __construct(
        private CursoService $cursoService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->cursoService->getAllPaginated()
        );
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function show(Curso $curso): JsonResponse
    {
        return response()->json([
            'data' => $curso
        ]);
    }

    public function edit(Curso $curso): JsonResponse
    {
        return response()->json($curso);
    }

    public function store(StoreCursoRequest $request): JsonResponse
    {
        $curso = $this->cursoService->create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Curso creado exitosamente',
            'data' => $curso
        ], 201);
    }

    public function update(
        UpdateCursoRequest $request,
        Curso $curso
    ): JsonResponse {
        $cursoActualizado = $this->cursoService->update(
            $curso,
            $request->validated()
        );

        return response()->json([
            'message' => 'Curso actualizado exitosamente',
            'data' => $cursoActualizado
        ]);
    }

    public function destroy(Curso $curso): JsonResponse
    {
        $this->cursoService->delete($curso);

        return response()->json([
            'message' => 'Curso eliminado exitosamente'
        ]);
    }

}