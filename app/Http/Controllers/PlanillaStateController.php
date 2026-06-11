<?php

namespace App\Http\Controllers;

use App\Models\PlanillaState;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanillaStateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $states = PlanillaState::where('user_id', $request->user()->id)->get();

        return response()->json($states);
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

        return response()->json($state, 201);
    }
}
