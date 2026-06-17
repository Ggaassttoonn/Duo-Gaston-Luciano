<?php

namespace App\Contracts\Repositories;

use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NotificationRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        Notification $notification
    ): Notification;

    public function create(
        array $data
    ): Notification;

    public function update(
        Notification $notification,
        array $data
    ): Notification;

    public function delete(
        Notification $notification
    ): bool;
}
