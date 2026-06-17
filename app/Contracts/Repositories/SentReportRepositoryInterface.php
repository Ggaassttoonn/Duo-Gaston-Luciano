<?php

namespace App\Contracts\Repositories;

use App\Models\SentReport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SentReportRepositoryInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        SentReport $sentReport
    ): SentReport;

    public function create(
        array $data
    ): SentReport;

    public function update(
        SentReport $sentReport,
        array $data
    ): SentReport;

    public function delete(
        SentReport $sentReport
    ): bool;
}
