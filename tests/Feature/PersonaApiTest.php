<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonaApiTest extends TestCase
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

    public function test_list_personas(): void
    {
        $this->actingAs($this->user);

        Persona::create([
            'apellidos'        => 'García',
            'nombres'          => 'Juan',
            'dni'              => '11111111',
            'e-mail'           => 'juan@example.com',
            'telefono'         => '123456789',
            'direccion'        => 'Calle 1',
            'fecha_nacimiento' => '1990-05-15',
        ]);

        Persona::create([
            'apellidos'        => 'Pérez',
            'nombres'          => 'María',
            'dni'              => '22222222',
            'e-mail'           => 'maria@example.com',
            'telefono'         => '987654321',
            'direccion'        => 'Calle 2',
            'fecha_nacimiento' => '1985-10-20',
        ]);

        $response = $this->getJson('/api/personas');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_create_persona(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/personas', [
            'apellidos'        => 'López',
            'nombres'          => 'Carlos',
            'dni'              => 33333333,
            'e-mail'           => 'carlos@example.com',
            'telefono'         => '555555555',
            'direccion'        => 'Av. Siempre Viva 123',
            'fecha_nacimiento' => '1995-03-10',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'apellidos', 'nombres', 'dni', 'e-mail'])
            ->assertJsonPath('apellidos', 'López')
            ->assertJsonPath('nombres', 'Carlos');

        $this->assertDatabaseHas('personas', ['dni' => '33333333']);
    }

    public function test_show_persona(): void
    {
        $this->actingAs($this->user);

        $persona = Persona::create([
            'apellidos'        => 'Martínez',
            'nombres'          => 'Ana',
            'dni'              => '44444444',
            'e-mail'           => 'ana@example.com',
            'telefono'         => '111111111',
            'direccion'        => 'Calle 10',
            'fecha_nacimiento' => '1988-07-22',
        ]);

        $response = $this->getJson("/api/personas/{$persona->id}");

        $response->assertStatus(200)
            ->assertJsonPath('apellidos', 'Martínez')
            ->assertJsonPath('nombres', 'Ana');
    }

    public function test_update_persona(): void
    {
        $this->actingAs($this->user);

        $persona = Persona::create([
            'apellidos'        => 'Fernández',
            'nombres'          => 'Pedro',
            'dni'              => '55555555',
            'e-mail'           => 'pedro@example.com',
            'telefono'         => '222222222',
            'direccion'        => 'Calle 20',
            'fecha_nacimiento' => '1992-11-30',
        ]);

        $response = $this->putJson("/api/personas/{$persona->id}", [
            'apellidos' => 'Fernández Actualizado',
            'telefono'  => '999999999',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('apellidos', 'Fernández Actualizado');
    }

    public function test_delete_persona(): void
    {
        $this->actingAs($this->user);

        $persona = Persona::create([
            'apellidos'        => 'Gómez',
            'nombres'          => 'Laura',
            'dni'              => '66666666',
            'e-mail'           => 'laura@example.com',
            'telefono'         => '333333333',
            'direccion'        => 'Calle 30',
            'fecha_nacimiento' => '1998-09-05',
        ]);

        $response = $this->deleteJson("/api/personas/{$persona->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('personas', ['id' => $persona->id]);
    }

    public function test_create_persona_validation_fails(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/personas', [
            'apellidos' => '',
            'nombres'   => '',
            'dni'       => '',
            'e-mail'    => 'not-an-email',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['apellidos', 'nombres', 'dni', 'e-mail']);
    }

    public function test_create_persona_duplicate_dni_fails(): void
    {
        $this->actingAs($this->user);

        Persona::create([
            'apellidos'        => 'Original',
            'nombres'          => 'User',
            'dni'              => '77777777',
            'e-mail'           => 'original@example.com',
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => '2000-01-01',
        ]);

        $response = $this->postJson('/api/personas', [
            'apellidos'        => 'Duplicado',
            'nombres'          => 'User',
            'dni'              => '77777777',
            'e-mail'           => 'otro@example.com',
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => '2000-01-01',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['dni']);
    }

    public function test_unauthenticated_access_returns_401(): void
    {
        $response = $this->getJson('/api/personas');

        $response->assertStatus(401);
    }
}
