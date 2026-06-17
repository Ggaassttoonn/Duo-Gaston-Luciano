<?php

namespace App\Contracts\Repositories;

use App\Models\UserPreference;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserPreferenceRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        UserPreference $userPreference
    ): UserPreference;

    public function create(
        array $data
    ): UserPreference;

    public function update(
        UserPreference $userPreference,
        array $data
    ): UserPreference;

    public function delete(
        UserPreference $userPreference
    ): bool;
}
