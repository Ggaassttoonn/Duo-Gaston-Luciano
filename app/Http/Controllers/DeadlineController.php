<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\DeadlineServiceInterface;
use App\Http\Requests\Deadline\StoreDeadlineRequest;
use App\Http\Requests\Deadline\UpdateDeadlineRequest;
use App\Http\Resources\DeadlineDetailResource;
use App\Http\Resources\DeadlineResource;
use App\Models\Deadline;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DeadlineController extends Controller
{
    public function __construct(
        private DeadlineServiceInterface $deadlineService
    ) {}

    public function index(): JsonResponse
    {
        $this->authorizeDirector();

        $deadlines = $this->deadlineService->getAll();

        return DeadlineResource::collection($deadlines)->response();
    }

    public function store(StoreDeadlineRequest $request): JsonResponse
    {
        $this->authorizeDirector();

        $deadline = $this->deadlineService->create($request->validated());

        return response()->json(DeadlineDetailResource::make($deadline), 201);
    }

    public function show(Deadline $deadline): JsonResponse
    {
        $this->authorizeDirector();

        $deadline = $this->deadlineService->getById($deadline);

        return response()->json(DeadlineDetailResource::make($deadline));
    }

    public function update(UpdateDeadlineRequest $request, Deadline $deadline): JsonResponse
    {
        $this->authorizeDirector();

        $deadline = $this->deadlineService->update($deadline, $request->validated());

        return response()->json(DeadlineDetailResource::make($deadline));
    }

    public function destroy(Deadline $deadline): JsonResponse
    {
        $this->authorizeDirector();

        $this->deadlineService->delete($deadline);

        return response()->json(['message' => 'Plazo eliminado correctamente.']);
    }

    private function authorizeDirector(): void
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'director'])) {
            abort(403, 'Solo el director puede realizar esta acción.');
        }
    }
}
