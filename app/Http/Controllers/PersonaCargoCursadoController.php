<?php

namespace App\Http\Controllers;

use App\Models\PersonaCargoCursado;
use App\Http\Requests\PersonaCargoCursado\StorePersonaCargoCursadoRequest;
use App\Http\Requests\PersonaCargoCursado\UpdatePersonaCargoCursadoRequest;
use App\Services\PersonaCargoCursadoService;
use Illuminate\Http\Request;
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
        return response()->json($personaCargoCursados);
    }

    public function show(PersonaCargoCursado $personaCargoCursado): JsonResponse
    {
        $personaCargoCursadoResuelto = $this->personaCargoCursadoService->getById($personaCargoCursado);
        return response()->json($personaCargoCursadoResuelto);
    }

    public function create(): JsonResponse
    {
        $options = $this->personaCargoCursadoService->getSelectOptions();
        return response()->json($options);
    }

    public function store(StorePersonaCargoCursadoRequest $request): JsonResponse
    {
        $personaCargoCursado = $this->personaCargoCursadoService->create($request->validated());
        return response()->json($personaCargoCursado, 201);
    }

    public function edit(PersonaCargoCursado $personaCargoCursado): JsonResponse
    {
        $options = $this->personaCargoCursadoService->getSelectOptions();
        return response()->json(['personaCargoCursado' => $personaCargoCursado] + $options);
    }

    public function update(UpdatePersonaCargoCursadoRequest $request, PersonaCargoCursado $personaCargoCursado): JsonResponse
    {
        $personaCargoCursadoActualizada = $this->personaCargoCursadoService->update($personaCargoCursado, $request->validated());
        return response()->json($personaCargoCursadoActualizada);
    }

    public function destroy(PersonaCargoCursado $personaCargoCursado): JsonResponse
    {
        $this->personaCargoCursadoService->delete($personaCargoCursado);
        return response()->json(null, 204);
    }

}
