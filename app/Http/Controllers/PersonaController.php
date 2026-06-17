<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Http\Requests\Persona\StorePersonaRequest;
use App\Http\Requests\Persona\UpdatePersonaRequest;
use App\Http\Resources\PersonaResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\PersonaServiceInterface;

class PersonaController extends Controller
{
    public function __construct(
        private PersonaServiceInterface $personaService
    ) {}

    public function index(): JsonResponse
    {
        $personas = $this->personaService->getAllPaginated();
        return PersonaResource::collection($personas)->response();
    }

    public function show(Persona $persona): JsonResponse
    {
        $personaResuelta = $this->personaService->getById($persona);
        return response()->json(PersonaResource::make($personaResuelta));
    }

    public function store(StorePersonaRequest $request): JsonResponse
    {
        $persona = $this->personaService->create($request->validated());
        return response()->json(PersonaResource::make($persona), 201);
    }

    public function update(UpdatePersonaRequest $request, Persona $persona): JsonResponse
    {
        $personaActualizada = $this->personaService->update($persona, $request->validated());
        return response()->json(PersonaResource::make($personaActualizada));
    }

    public function destroy(Persona $persona): JsonResponse
    {
        $this->personaService->delete($persona);
        return response()->json(null, 204);
    }
}
