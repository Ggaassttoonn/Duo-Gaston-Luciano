<?php

namespace App\Http\Controllers;

use App\Models\PersonaCargo;
use App\Http\Requests\PersonaCargo\StorePersonaCargoRequest;
use App\Http\Requests\PersonaCargo\UpdatePersonaCargoRequest;
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
        return response()->json($personaCargos);
    }

    public function show(PersonaCargo $personaCargo): JsonResponse
    {
        $personaCargoResuelto = $this->personaCargoService->getById($personaCargo);
        return response()->json($personaCargoResuelto);
    }

    public function create(): JsonResponse
    {
        $options = $this->personaCargoService->getSelectOptions();
        return response()->json($options);
    }

    public function store(StorePersonaCargoRequest $request): JsonResponse
    {
        $personaCargo = $this->personaCargoService->create($request->validated());
        return response()->json($personaCargo, 201);
    }

    public function edit(PersonaCargo $personaCargo): JsonResponse
    {
        $options = $this->personaCargoService->getSelectOptions();
        return response()->json(['personaCargo' => $personaCargo] + $options);
    }

    public function update(UpdatePersonaCargoRequest $request, PersonaCargo $personaCargo): JsonResponse
    {
        $personaCargoActualizada = $this->personaCargoService->update($personaCargo, $request->validated());
        return response()->json($personaCargoActualizada);
    }

    public function destroy(PersonaCargo $personaCargo): JsonResponse
    {
        $this->personaCargoService->delete($personaCargo);
        return response()->json(null, 204);
    }
}
