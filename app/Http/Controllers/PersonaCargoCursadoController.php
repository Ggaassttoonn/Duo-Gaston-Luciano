<?php

namespace App\Http\Controllers;

use App\Models\PersonaCargoCursado;
use App\Http\Requests\PersonaCargoCursado\StorePersonaCargoCursadoRequest;
use App\Http\Requests\PersonaCargoCursado\UpdatePersonaCargoCursadoRequest;
use App\Http\Resources\PersonaCargoCursadoResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\PersonaCargoCursadoServiceInterface;

class PersonaCargoCursadoController extends Controller
{
    public function __construct(private PersonaCargoCursadoServiceInterface $personaCargoCursadoService)
    {
    }

    public function index(): JsonResponse
    {
        $personaCargoCursados = $this->personaCargoCursadoService->getAllPaginated();
        return PersonaCargoCursadoResource::collection($personaCargoCursados)->response();
    }

    public function show(PersonaCargoCursado $personaCargoCursado): JsonResponse
    {
        $personaCargoCursadoResuelto = $this->personaCargoCursadoService->getById($personaCargoCursado);
        return response()->json(PersonaCargoCursadoResource::make($personaCargoCursadoResuelto));
    }

    public function store(StorePersonaCargoCursadoRequest $request): JsonResponse
    {
        $personaCargoCursado = $this->personaCargoCursadoService->create($request->validated());
        return response()->json(PersonaCargoCursadoResource::make($personaCargoCursado), 201);
    }

    public function update(UpdatePersonaCargoCursadoRequest $request, PersonaCargoCursado $personaCargoCursado): JsonResponse
    {
        $personaCargoCursadoActualizada = $this->personaCargoCursadoService->update($personaCargoCursado, $request->validated());
        return response()->json(PersonaCargoCursadoResource::make($personaCargoCursadoActualizada));
    }

    public function destroy(PersonaCargoCursado $personaCargoCursado): JsonResponse
    {
        $this->personaCargoCursadoService->delete($personaCargoCursado);
        return response()->json(null, 204);
    }

}
