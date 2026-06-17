<?php

namespace App\Http\Controllers;

use App\Models\PlanillaState;
use App\Http\Resources\PlanillaStateResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanillaStateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $states = PlanillaState::where('user_id', $request->user()->id)->get();

        return PlanillaStateResource::collection($states)->response();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'planilla_id' => 'required|integer|exists:planillas,id',
            'estado' => 'required|string',
        ]);

        $data['user_id'] = $request->user()->id;

        $state = PlanillaState::updateOrCreate(
            ['planilla_id' => $data['planilla_id'], 'user_id' => $data['user_id']],
            ['estado' => $data['estado']]
        );

        return response()->json(PlanillaStateResource::make($state), 201);
    }
}
