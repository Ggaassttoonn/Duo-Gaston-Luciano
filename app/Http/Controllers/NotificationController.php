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
        try {
            $input = $request->all();
            if (!isset($input['title']) && isset($input['titulo'])) {
                $input['title'] = $input['titulo'];
            }
            if (!isset($input['type']) && isset($input['tipo'])) {
                $input['type'] = $input['tipo'];
            }
            if (!isset($input['user_id']) && isset($input['docente_id'])) {
                $input['user_id'] = $input['docente_id'];
            }
            $request->merge($input);

            $data = $request->validate([
                'type' => 'required|string',
                'title' => 'required|string',
                'message' => 'nullable|string',
                'data' => 'nullable|array',
                'planilla_id' => 'nullable|integer|exists:planillas,id',
                'user_id' => 'nullable|integer|exists:users,id',
            ]);

            $currentUser = $request->user();
            if (!isset($data['user_id']) || !in_array($currentUser->role, ['admin', 'director'])) {
                $data['user_id'] = $currentUser->id;
            }

            $notification = Notification::create($data);

            return response()->json([
                'message' => 'Notificación creada.',
                'notification' => NotificationResource::make($notification),
                'debug' => [
                    'saved_user_id' => $data['user_id'],
                    'current_user_id' => $currentUser->id,
                    'current_user_role' => $currentUser->role,
                ],
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error al crear notificación.',
                'error' => $e->getMessage(),
                'file' => basename($e->getFile()) . ':' . $e->getLine(),
            ], 500);
        }
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
