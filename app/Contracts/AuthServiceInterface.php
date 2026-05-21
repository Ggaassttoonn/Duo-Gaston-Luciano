<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface AuthServiceInterface
{
    public function login(array $credentials, bool $remember = false): array;

    public function logout(): void;
}
