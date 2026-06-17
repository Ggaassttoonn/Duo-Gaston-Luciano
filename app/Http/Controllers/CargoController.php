<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\CargoServiceInterface;
use App\Http\Requests\Cargo\StoreCargoRequest;
use App\Http\Requests\Cargo\UpdateCargoRequest;
use App\Http\Resources\CargoResource;

class CargoController extends Controller
{
    public function __construct(
        protected CargoServiceInterface $cargoService
    ) {
    }

    public function index(): JsonResponse
    {
        $cargos = $this->cargoService->getAllPaginated();

        return CargoResource::collection($cargos)->response();
    }

    public function show(Cargo $cargo): JsonResponse
    {
        $cargoResuelto = $this->cargoService->getById($cargo);

        return response()->json(CargoResource::make($cargoResuelto));
    }

    public function store(StoreCargoRequest $request): JsonResponse
    {
        $cargo = $this->cargoService->create($request->validated());

        return response()->json(CargoResource::make($cargo), 201);
    }

    public function update(UpdateCargoRequest $request, Cargo $cargo): JsonResponse
    {
        $cargoActualizado = $this->cargoService->update(
            $cargo,
            $request->validated()
        );

        return response()->json(CargoResource::make($cargoActualizado));
    }

    public function destroy(Cargo $cargo): JsonResponse
    {
        $this->cargoService->delete($cargo);

        return response()->json(null, 204);
    }
}