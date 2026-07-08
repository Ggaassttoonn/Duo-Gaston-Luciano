<?php

namespace Tests\Feature;

use App\Models\Materia;
use App\Models\Persona;
use App\Models\Users;
use App\Models\Area;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MateriaApiTest extends TestCase
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
            'email'            => 'admin@example.com',
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

    public function test_list_materias(): void
    {
        $this->actingAs($this->user);

        Materia::create(['nombre' => 'Matemática']);
        Materia::create(['nombre' => 'Lengua']);

        $response = $this->getJson('/api/materias');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_create_materia(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/materias', [
            'nombre' => 'Ciencias Naturales',
            'primer_ciclo' => true,
            'segundo_ciclo' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'nombre', 'primer_ciclo', 'segundo_ciclo', 'tercer_ciclo', 'created_at', 'updated_at'])
            ->assertJsonPath('nombre', 'Ciencias Naturales')
            ->assertJsonPath('primer_ciclo', true);

        $this->assertDatabaseHas('materias', ['nombre' => 'Ciencias Naturales']);
    }

    public function test_show_materia(): void
    {
        $this->actingAs($this->user);

        $materia = Materia::create(['nombre' => 'Historia']);

        $response = $this->getJson("/api/materias/{$materia->id}");

        $response->assertStatus(200)
            ->assertJsonPath('nombre', 'Historia');
    }

    public function test_update_materia(): void
    {
        $this->actingAs($this->user);

        $materia = Materia::create(['nombre' => 'Geografía']);

        $response = $this->putJson("/api/materias/{$materia->id}", [
            'nombre' => 'Geografía Actualizada',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('nombre', 'Geografía Actualizada');
    }

    public function test_delete_materia(): void
    {
        $this->actingAs($this->user);

        $materia = Materia::create(['nombre' => 'Física']);

        $response = $this->deleteJson("/api/materias/{$materia->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('materias', ['id' => $materia->id]);
    }

    public function test_unauthenticated_access_returns_401(): void
    {
        $response = $this->getJson('/api/materias');

        $response->assertStatus(401);
    }

    public function test_create_materia_validation_fails(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/materias', [
            'nombre' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nombre']);
    }

    public function test_create_materia_duplicate_name_fails(): void
    {
        $this->actingAs($this->user);

        Materia::create(['nombre' => 'Única']);

        $response = $this->postJson('/api/materias', [
            'nombre' => 'Única',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nombre']);
    }

    public function test_create_materia_with_area(): void
    {
        $this->actingAs($this->user);

        $area = Area::create(['area' => 'Ciencias', 'tipo' => 'básico']);

        $response = $this->postJson('/api/materias', [
            'nombre' => 'Biología',
            'area_id' => $area->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('area_id', $area->id);
    }
}
