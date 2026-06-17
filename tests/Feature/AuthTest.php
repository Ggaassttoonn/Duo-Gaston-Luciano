<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(array $overrides = []): Users
    {
        $persona = Persona::create([
            'apellidos'        => $overrides['apellidos'] ?? 'Test',
            'nombres'          => $overrides['nombres'] ?? 'User',
            'dni'              => $overrides['dni'] ?? '12345678',
            'e-mail'           => $overrides['email'] ?? 'test@example.com',
            'telefono'         => $overrides['telefono'] ?? '',
            'direccion'        => $overrides['direccion'] ?? '',
            'fecha_nacimiento' => $overrides['fecha_nacimiento'] ?? '2000-01-01',
        ]);

        return Users::create([
            'persona_id' => $persona->id,
            'name'       => $overrides['name'] ?? 'Test User',
            'email'      => $overrides['email'] ?? 'test@example.com',
            'password'   => $overrides['password'] ?? 'password',
            'role'       => $overrides['role'] ?? 'docente',
        ]);
    }

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Nuevo Usuario',
            'email'                 => 'nuevo@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'role', 'foto'],
                'token',
                'role',
                'foto',
                'persona_id',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@example.com',
        ]);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $this->createUser([
            'email'    => 'login@example.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'login@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'role', 'foto'],
                'token',
                'role',
                'foto',
                'persona_id',
                'preferences',
            ]);
    }

    public function test_login_with_invalid_credentials_returns_422(): void
    {
        $this->createUser([
            'email'    => 'valid@example.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'valid@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_get_own_profile(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->getJson('/api/auth/me');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'role', 'foto'],
                'role',
                'foto',
                'persona_id',
                'preferences',
            ])
            ->assertJsonPath('user.email', $user->email);
    }

    public function test_unauthenticated_user_cannot_access_me(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }

    public function test_user_can_update_profile(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->putJson('/api/auth/profile', [
            'name' => 'Nombre Actualizado',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('user.name', 'Nombre Actualizado')
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email', 'role', 'foto'],
                'role',
                'foto',
            ]);
    }

    public function test_user_can_logout(): void
    {
        $user = $this->createUser();
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Sesión cerrada correctamente.']);

        $this->assertCount(0, $user->fresh()->tokens);
    }

    public function test_register_requires_password_confirmation(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'     => 'Test',
            'email'    => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_register_with_invalid_email_returns_422(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'                  => 'Test',
            'email'                 => 'not-an-email',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
