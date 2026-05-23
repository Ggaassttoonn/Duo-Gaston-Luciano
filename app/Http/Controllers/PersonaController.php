<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Http\Requests\Persona\StorePersonaRequest;
use App\Http\Requests\Persona\UpdatePersonaRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\PersonaServiceInterface;

class PersonaController extends Controller
{
    public function __construct(
        private PersonaServiceInterface $personaService
    ) {}

    public function index(): JsonResponse
    {
        $personas = $this->personaService->getAllPaginated();
        return response()->json($personas);
    }

    public function show(Persona $persona): JsonResponse
    {
        $personaResuelta = $this->personaService->getById($persona);
        return response()->json($personaResuelta);
    }

    public function create(): JsonResponse
    {
        return response()->json([]); // No data needed for create form initially
    }

    public function store(StorePersonaRequest $request): JsonResponse
    {
        $persona = $this->personaService->create($request->validated());
        return response()->json($persona, 201);
    }

    public function edit(Persona $persona): JsonResponse
    {
        return response()->json($persona); // Return the persona data for editing
    }

    public function update(UpdatePersonaRequest $request, Persona $persona): JsonResponse
    {
        $personaActualizada = $this->personaService->update($persona, $request->validated());
        return response()->json($personaActualizada);
    }

    public function destroy(Persona $persona): JsonResponse
    {
        $this->personaService->delete($persona);
        return response()->json(null, 204);
    }
}
