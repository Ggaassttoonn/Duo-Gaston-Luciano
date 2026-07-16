<?php

namespace App\Http\Controllers;

use App\Models\SentReport;
use App\Models\Notification;
use App\Http\Resources\SentReportResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SentReportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (in_array($user->role, ['admin', 'director'])) {
            $reports = SentReport::where('director_id', $user->id)
                ->with('docente', 'planilla')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $reports = SentReport::where('docente_id', $user->id)
                ->with('director', 'planilla')
                ->orderBy('created_at', 'desc')
                ->get();
        }

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

        $notificationData = [];
        if (!empty($data['audio_base64'])) {
            $notificationData['audio_base64'] = $data['audio_base64'];
            $notificationData['audio_mime'] = $data['audio_mime'] ?? 'audio/webm';
        }
        if (!empty($data['comentario'])) {
            $notificationData['comentario'] = $data['comentario'];
        }

        Notification::create([
            'user_id' => $data['docente_id'],
            'type' => 'reporte_recibido',
            'title' => 'Nuevo reporte recibido',
            'message' => $data['comentario'] ?: 'Tu director te envió un reporte.',
            'planilla_id' => $data['planilla_id'] ?? null,
            'data' => $notificationData,
        ]);

        return response()->json(SentReportResource::make($report), 201);
    }
}
