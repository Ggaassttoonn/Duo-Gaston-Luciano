<?php

namespace App\Contracts\Interfaces;

interface AuthServiceInterface
{
    public function login(array $credentials): array;

    public function register(array $data): array;

    public function me(): array;

    public function updateProfile(array $data): array;

    public function updatePreferences(array $preferences): array;

    public function getPreferences(): array;

    public function logout(): void;
}
