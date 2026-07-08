<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AssignmentServiceInterface;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\MyAssignmentResource;
use App\Models\Assignment;
use Illuminate\Http\JsonResponse;

class AssignmentController extends Controller
{
    public function __construct(
        private AssignmentServiceInterface $assignmentService
    ) {}

    public function getAssignments(int $deadlineId): JsonResponse
    {
        $this->authorizeDirector();

        $assignments = $this->assignmentService->getByDeadline($deadlineId);

        return AssignmentResource::collection($assignments)->response();
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment): JsonResponse
    {
        $assignment = $this->assignmentService->update($assignment, $request->validated());

        return response()->json(AssignmentResource::make($assignment));
    }

    public function getMyAssignments(): JsonResponse
    {
        $assignments = $this->assignmentService->getMyAssignments();

        return MyAssignmentResource::collection($assignments)->response();
    }

    private function authorizeDirector(): void
    {
        $user = request()->user();

        if (!in_array($user->role, ['admin', 'director'])) {
            abort(403, 'Solo el director puede realizar esta acción.');
        }
    }
}
