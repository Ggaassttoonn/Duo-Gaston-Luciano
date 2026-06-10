<?php

namespace App\Services;

use App\Contracts\Interfaces\AuthServiceInterface;
use App\Models\Persona;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials): array
    {
        $user = Users::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
            ]);
        }

        $token = $user->createToken('api')->plainTextToken;

        $user->load('persona');

        return [
            'token'      => $token,
            'user'       => [
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'role'       => $user->role,
            'persona_id' => $user->persona_id,
            'foto'       => null,
        ];
    }

    public function register(array $data): array
    {
        $parts = explode(' ', $data['name'], 2);
        $nombres = $parts[0];
        $apellidos = $parts[1] ?? '';

        $persona = Persona::create([
            'apellidos'       => $apellidos,
            'nombres'         => $nombres,
            'dni'             => 'TEMP-' . uniqid(),
            'e-mail'          => $data['email'],
            'telefono'        => '',
            'direccion'       => '',
            'fecha_nacimiento' => now()->toDateString(),
        ]);

        $user = Users::create([
            'persona_id' => $persona->id,
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => $data['password'],
            'role'       => 'docente',
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return [
            'token'      => $token,
            'user'       => [
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'role'       => $user->role,
            'persona_id' => $user->persona_id,
            'foto'       => null,
        ];
    }

    public function me(): array
    {
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages(['message' => ['No autenticado.']]);
        }

        $user->load('persona');

        return [
            'user'       => [
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'role'       => $user->role,
            'persona_id' => $user->persona_id,
            'foto'       => null,
        ];
    }

    public function updateProfile(array $data): array
    {
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages(['message' => ['No autenticado.']]);
        }

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['foto'])) {
            // Store foto handling logic here
        }

        $user->save();

        return [
            'message' => 'Perfil actualizado correctamente.',
            'user'    => [
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ];
    }

    public function logout(): void
    {
        $user = Auth::user();

        if ($user) {
            $user->currentAccessToken()->delete();
        }
    }
}
