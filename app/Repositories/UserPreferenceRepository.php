<?php

namespace App\Repositories;

use App\Models\UserPreference;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\UserPreferenceRepositoryInterface;

class UserPreferenceRepository implements UserPreferenceRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return UserPreference::paginate($perPage);
    }

    public function getById(
        UserPreference $userPreference
    ): UserPreference {
        return $userPreference;
    }

    public function create(
        array $data
    ): UserPreference {
        return UserPreference::create($data);
    }

    public function update(
        UserPreference $userPreference,
        array $data
    ): UserPreference {
        $userPreference->update($data);

        return $userPreference;
    }

    public function delete(
        UserPreference $userPreference
    ): bool {
        return $userPreference->delete();
    }
}
