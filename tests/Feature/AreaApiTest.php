<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Persona;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaApiTest extends TestCase
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

    public function test_list_areas(): void
    {
        $this->actingAs($this->user);

        Area::create(['area' => 'Matemática', 'tipo' => 'Ciclo Básico']);
        Area::create(['area' => 'Lengua',    'tipo' => 'Ciclo Básico']);

        $response = $this->getJson('/api/areas');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_create_area(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/areas', [
            'area' => 'Ciencias Naturales',
            'tipo' => 'Ciclo Orientado',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'area', 'tipo', 'created_at', 'updated_at'])
            ->assertJsonPath('area', 'Ciencias Naturales')
            ->assertJsonPath('tipo', 'Ciclo Orientado');

        $this->assertDatabaseHas('areas', ['area' => 'Ciencias Naturales']);
    }

    public function test_show_area(): void
    {
        $this->actingAs($this->user);

        $area = Area::create(['area' => 'Historia', 'tipo' => 'Ciclo Básico']);

        $response = $this->getJson("/api/areas/{$area->id}");

        $response->assertStatus(200)
            ->assertJsonPath('area', 'Historia')
            ->assertJsonPath('tipo', 'Ciclo Básico');
    }

    public function test_update_area(): void
    {
        $this->actingAs($this->user);

        $area = Area::create(['area' => 'Geografía', 'tipo' => 'Ciclo Básico']);

        $response = $this->putJson("/api/areas/{$area->id}", [
            'area' => 'Geografía Actualizada',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('area', 'Geografía Actualizada');
    }

    public function test_delete_area(): void
    {
        $this->actingAs($this->user);

        $area = Area::create(['area' => 'Física', 'tipo' => 'Ciclo Orientado']);

        $response = $this->deleteJson("/api/areas/{$area->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('areas', ['id' => $area->id]);
    }

    public function test_unauthenticated_access_returns_401(): void
    {
        $response = $this->getJson('/api/areas');

        $response->assertStatus(401);
    }

    public function test_create_area_validation_fails(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/areas', [
            'area' => '',
            'tipo' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['area', 'tipo']);
    }

    public function test_create_area_duplicate_name_fails(): void
    {
        $this->actingAs($this->user);

        Area::create(['area' => 'Única', 'tipo' => 'Ciclo Básico']);

        $response = $this->postJson('/api/areas', [
            'area' => 'Única',
            'tipo' => 'Ciclo Orientado',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['area']);
    }
}
