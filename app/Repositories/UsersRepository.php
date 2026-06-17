<?php

namespace App\Repositories;

use App\Models\Users;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\UsersRepositoryInterface;

class UsersRepository implements UsersRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return Users::paginate($perPage);
    }

    public function getById(
        Users $users
    ): Users {
        return $users;
    }

    public function create(
        array $data
    ): Users {
        return Users::create($data);
    }

    public function update(
        Users $users,
        array $data
    ): Users {
        $users->update($data);

        return $users;
    }

    public function delete(
        Users $users
    ): bool {
        return $users->delete();
    }
}
