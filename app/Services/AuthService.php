<?php

namespace App\Services;

use App\Contracts\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials, bool $remember = false): array
    {
        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
            ]);
        }

        request()->session()->regenerate();

        return [
            'message' => '¡Inicio de sesión exitoso!',
            'user'    => Auth::user()->load('persona'),
        ];
    }

    public function logout(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
