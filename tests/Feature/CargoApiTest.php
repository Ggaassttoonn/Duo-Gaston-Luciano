<?php

namespace Tests\Feature;

use App\Models\Cargo;
use App\Models\Persona;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CargoApiTest extends TestCase
{
    use RefreshDatabase;

    private Users $user;

    protected function setUp(): void
    {
        parent::setUp();

        $persona = Persona::create([
            'apellidos'        => 'Admin',
            'nombres'          => 'User',
            'dni'              => '87654321',
            'e-mail'           => 'admin@example.com',
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => '2000-01-01',
        ]);

        $this->user = Users::create([
            'persona_id' => $persona->id,
            'name'       => 'Admin User',
            'email'      => 'admin@example.com',
            'password'   => 'password',
            'role'       => 'admin',
        ]);
    }

    public function test_list_cargos(): void
    {
        $this->actingAs($this->user);

        Cargo::create(['cargo' => 'Profesor']);
        Cargo::create(['cargo' => 'Preceptor']);

        $response = $this->getJson('/api/cargos');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_create_cargo(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/cargos', [
            'cargo' => 'Director',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'cargo', 'created_at', 'updated_at'])
            ->assertJsonPath('cargo', 'Director');

        $this->assertDatabaseHas('cargos', ['cargo' => 'Director']);
    }

    public function test_show_cargo(): void
    {
        $this->actingAs($this->user);

        $cargo = Cargo::create(['cargo' => 'Vicedirector']);

        $response = $this->getJson("/api/cargos/{$cargo->id}");

        $response->assertStatus(200)
            ->assertJsonPath('cargo', 'Vicedirector');
    }

    public function test_update_cargo(): void
    {
        $this->actingAs($this->user);

        $cargo = Cargo::create(['cargo' => 'Secretario']);

        $response = $this->putJson("/api/cargos/{$cargo->id}", [
            'cargo' => 'Secretario Actualizado',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('cargo', 'Secretario Actualizado');
    }

    public function test_delete_cargo(): void
    {
        $this->actingAs($this->user);

        $cargo = Cargo::create(['cargo' => 'Tutor']);

        $response = $this->deleteJson("/api/cargos/{$cargo->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('cargos', ['id' => $cargo->id]);
    }

    public function test_create_cargo_validation_fails(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/cargos', [
            'cargo' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cargo']);
    }

    public function test_create_cargo_duplicate_fails(): void
    {
        $this->actingAs($this->user);

        Cargo::create(['cargo' => 'Maestro']);

        $response = $this->postJson('/api/cargos', [
            'cargo' => 'Maestro',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cargo']);
    }

    public function test_unauthenticated_access_returns_401(): void
    {
        $response = $this->getJson('/api/cargos');

        $response->assertStatus(401);
    }
}
