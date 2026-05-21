<?php

namespace App\Contracts;

use App\Models\SitRevista;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SitRevistaServiceInterface
{
    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getById(
        SitRevista $sitRevista
    ): SitRevista;

    public function create(
        array $data
    ): SitRevista;

    public function update(
        SitRevista $sitRevista,
        array $data
    ): SitRevista;

    public function delete(
        SitRevista $sitRevista
    ): bool;
}