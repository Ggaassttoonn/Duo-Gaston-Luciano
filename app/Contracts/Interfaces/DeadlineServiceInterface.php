<?php

namespace App\Contracts\Interfaces;

use App\Models\Deadline;
use Illuminate\Database\Eloquent\Collection;

interface DeadlineServiceInterface
{
    public function getAll(): Collection;

    public function getById(Deadline $deadline): Deadline;

    public function create(array $data): Deadline;

    public function update(Deadline $deadline, array $data): Deadline;

    public function delete(Deadline $deadline): bool;
}
