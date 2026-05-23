<?php

namespace App\Services;

use App\Models\SitRevista;
use App\Contracts\Interfaces\SitRevistaServiceInterface;
use App\Contracts\Repositories\SitRevistaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SitRevistaService implements SitRevistaServiceInterface
{
    public function __construct(
        private SitRevistaRepositoryInterface $sitRevistaRepository
    ) {}

    public function getAllPaginated(
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->sitRevistaRepository->getAllPaginated($perPage);
    }

    public function getById(
        SitRevista $sitRevista
    ): SitRevista {
        return $this->sitRevistaRepository->getById($sitRevista);
    }

    public function create(array $data): SitRevista
    {
        return $this->sitRevistaRepository->create($data);
    }

    public function update(
        SitRevista $sitRevista,
        array $data
    ): SitRevista {
        return $this->sitRevistaRepository->update($sitRevista, $data);
    }

    public function delete(
        SitRevista $sitRevista
    ): bool {
        return $this->sitRevistaRepository->delete($sitRevista);
    }
}
