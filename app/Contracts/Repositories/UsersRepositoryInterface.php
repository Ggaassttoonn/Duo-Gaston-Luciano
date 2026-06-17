<?php

namespace App\Contracts\Repositories;

use App\Models\Users;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UsersRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        Users $users
    ): Users;

    public function create(
        array $data
    ): Users;

    public function update(
        Users $users,
        array $data
    ): Users;

    public function delete(
        Users $users
    ): bool;
}
