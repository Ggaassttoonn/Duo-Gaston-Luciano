<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return Notification::paginate($perPage);
    }

    public function getById(
        Notification $notification
    ): Notification {
        return $notification;
    }

    public function create(
        array $data
    ): Notification {
        return Notification::create($data);
    }

    public function update(
        Notification $notification,
        array $data
    ): Notification {
        $notification->update($data);

        return $notification;
    }

    public function delete(
        Notification $notification
    ): bool {
        return $notification->delete();
    }
}
