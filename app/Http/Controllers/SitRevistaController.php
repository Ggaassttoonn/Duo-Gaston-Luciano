<?php

namespace App\Http\Controllers;

use App\Models\SitRevista;
use App\Http\Requests\SitRevista\StoreSitRevistaRequest;
use App\Http\Requests\SitRevista\UpdateSitRevistaRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\SitRevistaServiceInterface;

class SitRevistaController extends Controller
{
    public function __construct(
        private SitRevistaServiceInterface $sitRevistaService
    ) {}

    public function index(): JsonResponse
    {
        $sitRevistas = $this->sitRevistaService->getAllPaginated();
        return response()->json($sitRevistas);
    }

    public function show(SitRevista $sitRevista): JsonResponse
    {
        $sitRevistaResuelta = $this->sitRevistaService->getById($sitRevista);
        return response()->json($sitRevistaResuelta);
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function store(StoreSitRevistaRequest $request): JsonResponse
    {
        $sitRevista = $this->sitRevistaService->create($request->validated());
        return response()->json($sitRevista, 201);
    }

    public function edit(SitRevista $sitRevista): JsonResponse
    {
        return response()->json($sitRevista);
    }

    public function update(UpdateSitRevistaRequest $request, SitRevista $sitRevista): JsonResponse
    {
        $sitRevistaActualizada = $this->sitRevistaService->update($sitRevista, $request->validated());
        return response()->json($sitRevistaActualizada);
    }

    public function destroy(SitRevista $sitRevista): JsonResponse
    {
        $this->sitRevistaService->delete($sitRevista);
        return response()->json(null, 204);
    }
}
