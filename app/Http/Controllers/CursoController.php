<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Curso\StoreCursoRequest;
use App\Http\Requests\Curso\UpdateCursoRequest;
use App\Http\Resources\CursoResource;
use App\Contracts\Interfaces\CursoServiceInterface;

class CursoController extends Controller
{
    public function __construct(
        private CursoServiceInterface $cursoService
    ) {
    }

    public function index(): JsonResponse
    {
        return CursoResource::collection(
            $this->cursoService->getAllPaginated()
        )->response();
    }

    public function show(Curso $curso): JsonResponse
    {
        $cursoResuelto = $this->cursoService->getById($curso);

        return response()->json(CursoResource::make($cursoResuelto));
    }

    public function store(StoreCursoRequest $request): JsonResponse
    {
        $curso = $this->cursoService->create(
            $request->validated()
        );

        return response()->json(CursoResource::make($curso), 201);
    }

    public function update(
        UpdateCursoRequest $request,
        Curso $curso
    ): JsonResponse {
        $cursoActualizado = $this->cursoService->update(
            $curso,
            $request->validated()
        );

        return response()->json(CursoResource::make($cursoActualizado));
    }

    public function destroy(Curso $curso): JsonResponse
    {
        $this->cursoService->delete($curso);

        return response()->json(null, 204);
    }

}