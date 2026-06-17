<?php

namespace App\Http\Controllers;

use App\Models\PersonaCargo;
use App\Http\Requests\PersonaCargo\StorePersonaCargoRequest;
use App\Http\Requests\PersonaCargo\UpdatePersonaCargoRequest;
use App\Http\Resources\PersonaCargoResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\PersonaCargoServiceInterface;

class PersonaCargoController extends Controller
{
    public function __construct(
        private PersonaCargoServiceInterface $personaCargoService
    ) {}

    public function index(): JsonResponse
    {
        $personaCargos = $this->personaCargoService->getAllPaginated();
        return PersonaCargoResource::collection($personaCargos)->response();
    }

    public function show(PersonaCargo $personaCargo): JsonResponse
    {
        $personaCargoResuelto = $this->personaCargoService->getById($personaCargo);
        return response()->json(PersonaCargoResource::make($personaCargoResuelto));
    }

    public function store(StorePersonaCargoRequest $request): JsonResponse
    {
        $personaCargo = $this->personaCargoService->create($request->validated());
        return response()->json(PersonaCargoResource::make($personaCargo), 201);
    }

    public function update(UpdatePersonaCargoRequest $request, PersonaCargo $personaCargo): JsonResponse
    {
        $personaCargoActualizada = $this->personaCargoService->update($personaCargo, $request->validated());
        return response()->json(PersonaCargoResource::make($personaCargoActualizada));
    }

    public function destroy(PersonaCargo $personaCargo): JsonResponse
    {
        $this->personaCargoService->delete($personaCargo);
        return response()->json(null, 204);
    }
}
