<?php

namespace App\Http\Controllers;

use App\Models\SitRevista;
use App\Http\Requests\SitRevista\StoreSitRevistaRequest;
use App\Http\Requests\SitRevista\UpdateSitRevistaRequest;
use App\Http\Resources\SitRevistaResource;
use Illuminate\Http\JsonResponse;
use App\Contracts\Interfaces\SitRevistaServiceInterface;

class SitRevistaController extends Controller
{
    public function __construct(
        private SitRevistaServiceInterface $sitRevistaService
    ) {}

    public function index(): JsonResponse
    {
        $sitRevistas = $this->sitRevistaService->getAllPaginated();
        return SitRevistaResource::collection($sitRevistas)->response();
    }

    public function show(SitRevista $sitRevista): JsonResponse
    {
        $sitRevistaResuelta = $this->sitRevistaService->getById($sitRevista);
        return response()->json(SitRevistaResource::make($sitRevistaResuelta));
    }

    public function store(StoreSitRevistaRequest $request): JsonResponse
    {
        $sitRevista = $this->sitRevistaService->create($request->validated());
        return response()->json(SitRevistaResource::make($sitRevista), 201);
    }

    public function update(UpdateSitRevistaRequest $request, SitRevista $sitRevista): JsonResponse
    {
        $sitRevistaActualizada = $this->sitRevistaService->update($sitRevista, $request->validated());
        return response()->json(SitRevistaResource::make($sitRevistaActualizada));
    }

    public function destroy(SitRevista $sitRevista): JsonResponse
    {
        $this->sitRevistaService->delete($sitRevista);
        return response()->json(null, 204);
    }
}
