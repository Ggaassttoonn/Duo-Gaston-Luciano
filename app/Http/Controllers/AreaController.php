<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AreaServiceInterface;
use App\Http\Requests\Area\StoreAreaRequest;
use App\Http\Requests\Area\UpdateAreaRequest;
use App\Http\Resources\AreaResource;
use App\Models\Area;
use Illuminate\Http\JsonResponse;

class AreaController extends Controller
{
    public function __construct(
        private AreaServiceInterface $areaService
    ) {}

    public function index(): JsonResponse
    {
        $areas = $this->areaService->getAllPaginated();

        return AreaResource::collection($areas)->response();
    }

    public function show(
        Area $area
    ): JsonResponse {
        $areaResuelta = $this->areaService
            ->getById($area);

        return response()->json(AreaResource::make($areaResuelta));
    }

    public function store(
        StoreAreaRequest $request
    ): JsonResponse {
        $area = $this->areaService
            ->create($request->validated());

        return response()->json(AreaResource::make($area), 201);
    }

    public function update(
        UpdateAreaRequest $request,
        Area $area
    ): JsonResponse {
        $areaActualizada = $this->areaService
            ->update($area, $request->validated());

        return response()->json(AreaResource::make($areaActualizada));
    }

    public function destroy(
        Area $area
    ): JsonResponse {
        $this->areaService->delete($area);

        return response()->json(null, 204);
    }
}