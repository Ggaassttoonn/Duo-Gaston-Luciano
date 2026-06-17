<?php

namespace App\Repositories;

use App\Models\SentReport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\SentReportRepositoryInterface;

class SentReportRepository implements SentReportRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return SentReport::paginate($perPage);
    }

    public function getById(
        SentReport $sentReport
    ): SentReport {
        return $sentReport;
    }

    public function create(
        array $data
    ): SentReport {
        return SentReport::create($data);
    }

    public function update(
        SentReport $sentReport,
        array $data
    ): SentReport {
        $sentReport->update($data);

        return $sentReport;
    }

    public function delete(
        SentReport $sentReport
    ): bool {
        return $sentReport->delete();
    }
}
