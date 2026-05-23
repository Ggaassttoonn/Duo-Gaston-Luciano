<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\JsonResponse;
use App\Contracts\CargoServiceInterface;
use App\Http\Requests\Cargo\StoreCargoRequest;
use App\Http\Requests\Cargo\UpdateCargoRequest;

class CargoController extends Controller
{
    public function __construct(
        protected CargoServiceInterface $cargoService
    ) {
    }

    public function index(): JsonResponse
    {
        $cargos = $this->cargoService->getAllPaginated();

        return response()->json($cargos);
    }

    public function show(Cargo $cargo): JsonResponse
    {
        $cargoResuelto = $this->cargoService->getById($cargo);

        return response()->json($cargoResuelto);
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function store(StoreCargoRequest $request): JsonResponse
    {
        $cargo = $this->cargoService->create($request->validated());

        return response()->json($cargo, 201);
    }

    public function edit(Cargo $cargo): JsonResponse
    {
        return response()->json($cargo);
    }

    public function update(UpdateCargoRequest $request, Cargo $cargo): JsonResponse
    {
        $cargoActualizado = $this->cargoService->update(
            $cargo,
            $request->validated()
        );

        return response()->json($cargoActualizado);
    }

    public function destroy(Cargo $cargo): JsonResponse
    {
        $this->cargoService->delete($cargo);

        return response()->json(null, 204);
    }
}