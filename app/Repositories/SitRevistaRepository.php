<?php

namespace App\Repositories;

use App\Models\SitRevista;
use App\Contracts\Repositories\SitRevistaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SitRevistaRepository implements SitRevistaRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return SitRevista::with('personaCargos')->paginate($perPage);
    }

    public function getById(SitRevista $sitRevista): SitRevista
    {
        return $sitRevista->load('personaCargos');
    }

    public function create(array $data): SitRevista
    {
        return SitRevista::create($data);
    }

    public function update(SitRevista $sitRevista, array $data): SitRevista
    {
        $sitRevista->update($data);

        return $sitRevista;
    }

    public function delete(SitRevista $sitRevista): bool
    {
        return $sitRevista->delete();
    }
}
