<?php

namespace App\Http\Controllers;

use App\Models\PlanillaRevision;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanillaRevisionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $revisions = PlanillaRevision::where('director_id', $request->user()->id)
            ->with('planilla')
            ->get();

        return response()->json($revisions);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'planilla_id' => 'required|integer|exists:planillas,id',
            'estado' => 'required|string',
            'comentario' => 'nullable|string',
            'audio_base64' => 'nullable|string',
            'audio_mime' => 'nullable|string',
            'planilla_original_id' => 'nullable|integer',
        ]);

        $data['director_id'] = $request->user()->id;

        $revision = PlanillaRevision::updateOrCreate(
            ['planilla_id' => $data['planilla_id'], 'director_id' => $data['director_id']],
            $data
        );

        $revision->load('director');

        return response()->json($revision, 201);
    }
}
