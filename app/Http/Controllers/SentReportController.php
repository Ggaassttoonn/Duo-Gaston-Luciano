<?php

namespace App\Http\Controllers;

use App\Models\SentReport;
use App\Http\Resources\SentReportResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SentReportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $reports = SentReport::where('director_id', $request->user()->id)
            ->with('docente', 'planilla')
            ->orderBy('created_at', 'desc')
            ->get();

        return SentReportResource::collection($reports)->response();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'planilla_id' => 'nullable|integer|exists:planillas,id',
            'docente_id' => 'required|integer|exists:users,id',
            'comentario' => 'nullable|string',
            'audio_base64' => 'nullable|string',
            'audio_mime' => 'nullable|string',
        ]);

        $data['director_id'] = $request->user()->id;

        $report = SentReport::create($data);

        $report->load('docente', 'planilla');

        return response()->json(SentReportResource::make($report), 201);
    }
}
