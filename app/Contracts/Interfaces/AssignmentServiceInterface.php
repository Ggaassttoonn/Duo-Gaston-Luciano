<?php

namespace App\Contracts\Interfaces;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Collection;

interface AssignmentServiceInterface
{
    public function getByDeadline(int $deadlineId): Collection;

    public function getMyAssignments(): Collection;

    public function update(Assignment $assignment, array $data): Assignment;
}
