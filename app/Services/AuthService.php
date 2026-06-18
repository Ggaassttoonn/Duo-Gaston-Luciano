<?php

namespace App\Services;

use App\Contracts\Interfaces\AuthServiceInterface;
use App\Models\Persona;
use App\Models\Users;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        $token = $user->createToken('auth-token')->plainTextToken;

        $user->load('persona', 'preferences');

        return [
            'user' => UsersResource::make($user)->resolve(),
            'token' => $token,
            'preferences' => $user->preferences->pluck('value', 'key')->toArray(),
        ];
    }

    public function register(array $data): array
    {
        $parts = explode(' ', $data['name'], 2);
        $nombres = $parts[0];
        $apellidos = $parts[1] ?? $nombres;

        $persona = Persona::firstOrCreate(
            ['email' => $data['email']],
            [
                'apellidos'        => $apellidos,
                'nombres'          => $nombres,
                'dni'              => 'TEMP-' . uniqid(),
                'telefono'         => '',
                'direccion'        => '',
                'fecha_nacimiento' => now()->toDateString(),
            ]
        );

        $user = Users::create([
            'persona_id' => $persona->id,
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => $data['password'],
            'role'       => $data['role'] ?? 'docente',
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        $user->load('persona');

        return [
            'user' => UsersResource::make($user)->resolve(),
            'token' => $token,
        ];
    }

    public function me(): array
    {
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages(['message' => ['No autenticado.']]);
        }

        $user->load('persona', 'preferences');

        return [
            'user' => UsersResource::make($user)->resolve(),
            'preferences' => $user->preferences->pluck('value', 'key')->toArray(),
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
            $user->foto = $this->saveFoto($data['foto']);
        }

        $user->save();

        $user->load('persona');

        return [
            'message' => 'Perfil actualizado correctamente.',
            'user' => UsersResource::make($user)->resolve(),
        ];
    }

    public function updatePreferences(array $preferences): array
    {
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages(['message' => ['No autenticado.']]);
        }

        foreach ($preferences as $key => $value) {
            $user->preferences()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $user->load('preferences');

        return ['preferences' => $user->preferences->pluck('value', 'key')->toArray()];
    }

    public function getPreferences(): array
    {
        $user = Auth::user();

        if (!$user) {
            throw ValidationException::withMessages(['message' => ['No autenticado.']]);
        }

        $user->load('preferences');

        return ['preferences' => $user->preferences->pluck('value', 'key')->toArray()];
    }

    private function saveFoto(string $dataUrl): string
    {
        if (!preg_match('/^data:image\/(jpeg|png|gif|webp);base64,/', $dataUrl)) {
            throw ValidationException::withMessages([
                'foto' => ['Formato de imagen no válido. Solo se permiten JPEG, PNG, GIF y WebP.'],
            ]);
        }

        $imageData = base64_decode(
            preg_replace('/^data:image\/\w+;base64,/', '', $dataUrl)
        );

        $maxSize = 2 * 1024 * 1024;

        if (strlen($imageData) > $maxSize) {
            throw ValidationException::withMessages([
                'foto' => ['La imagen no debe superar los 2 MB.'],
            ]);
        }

        $extension = strtolower(
            preg_replace('/^data:image\/(\w+);base64,/', '$1', $dataUrl)
        );

        $filename = 'fotos/' . uniqid() . '.' . $extension;

        if (!is_dir(storage_path('app/public/fotos'))) {
            Storage::disk('public')->makeDirectory('fotos');
        }

        Storage::disk('public')->put($filename, $imageData);

        $publicPath = public_path('storage');

        if (!file_exists($publicPath)) {
            try {
                app('files')->link(storage_path('app/public'), $publicPath);
            } catch (\Exception $e) {
                return Storage::disk('public')->url($filename);
            }
        }

        return Storage::disk('public')->url($filename);
    }

    public function logout(): void
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }
    }
}
