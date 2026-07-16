<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $notifications = Notification::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return NotificationResource::collection($notifications)->response();
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        if (!isset($input['title']) && isset($input['titulo'])) {
            $input['title'] = $input['titulo'];
        }
        $request->merge($input);

        $data = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string',
            'message' => 'nullable|string',
            'data' => 'nullable|array',
            'planilla_id' => 'nullable|integer|exists:planillas,id',
        ]);

        $data['user_id'] = $request->user()->id;

        $notification = Notification::create($data);

        return response()->json(NotificationResource::make($notification), 201);
    }

    public function markRead(Request $request, Notification $notification): JsonResponse
    {
        if ($notification->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $notification->update(['read' => true]);

        return response()->json(NotificationResource::make($notification));
    }

    public function markAllRead(Request $request): JsonResponse
    {
        Notification::where('user_id', $request->user()->id)
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json(['message' => 'Todas las notificaciones marcadas como leídas.']);
    }

    public function destroy(Request $request, Notification $notification): JsonResponse
    {
        if ($notification->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $notification->delete();

        return response()->json(['message' => 'Notificación eliminada.']);
    }
}
