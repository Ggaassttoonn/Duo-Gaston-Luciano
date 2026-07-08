<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\MateriaServiceInterface;
use App\Http\Requests\Materia\StoreMateriaRequest;
use App\Http\Requests\Materia\UpdateMateriaRequest;
use App\Http\Resources\MateriaResource;
use App\Models\Materia;
use Illuminate\Http\JsonResponse;

class MateriaController extends Controller
{
    public function __construct(
        private MateriaServiceInterface $materiaService
    ) {}

    public function index(): JsonResponse
    {
        $materias = $this->materiaService->getAllPaginated();

        return MateriaResource::collection($materias)->response();
    }

    public function show(Materia $materia): JsonResponse
    {
        $materiaResuelta = $this->materiaService->getById($materia);

        return response()->json(MateriaResource::make($materiaResuelta));
    }

    public function store(StoreMateriaRequest $request): JsonResponse
    {
        $materia = $this->materiaService->create($request->validated());

        return response()->json(MateriaResource::make($materia), 201);
    }

    public function update(UpdateMateriaRequest $request, Materia $materia): JsonResponse
    {
        $materiaActualizada = $this->materiaService->update($materia, $request->validated());

        return response()->json(MateriaResource::make($materiaActualizada));
    }

    public function destroy(Materia $materia): JsonResponse
    {
        $this->materiaService->delete($materia);

        return response()->json(null, 204);
    }
}
