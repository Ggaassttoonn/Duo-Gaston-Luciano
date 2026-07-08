<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\Planilla;
use App\Models\PlanillaDestinatario;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanillaApiTest extends TestCase
{
    use RefreshDatabase;

    private Users $user;
    private Users $director;

    protected function setUp(): void
    {
        parent::setUp();

        $personaA = Persona::create([
            'apellidos'        => 'Docente',
            'nombres'          => 'Usuario',
            'dni'              => '11111111',
            'email'           => 'docente@example.com',
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => '2000-01-01',
        ]);

        $this->user = Users::create([
            'persona_id' => $personaA->id,
            'name'       => 'Docente Usuario',
            'email'      => 'docente@example.com',
            'password'   => 'password',
            'role'       => 'docente',
        ]);

        $personaB = Persona::create([
            'apellidos'        => 'Director',
            'nombres'          => 'Usuario',
            'dni'              => '22222222',
            'email'           => 'director@example.com',
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => '2000-01-01',
        ]);

        $this->director = Users::create([
            'persona_id' => $personaB->id,
            'name'       => 'Director Usuario',
            'email'      => 'director@example.com',
            'password'   => 'password',
            'role'       => 'admin',
        ]);
    }

    public function test_list_planillas_requires_user_id(): void
    {
        $this->actingAs($this->user);

        $response = $this->getJson('/api/planillas');

        $response->assertStatus(400)
            ->assertJson(['message' => 'user_id es requerido.']);
    }

    public function test_list_planillas_by_user_id(): void
    {
        $this->actingAs($this->user);

        Planilla::create([
            'titulo'     => 'Planilla 1',
            'contenido'  => 'Contenido 1',
            'user_id' => $this->user->id,
            'estado'     => 'borrador',
        ]);

        Planilla::create([
            'titulo'     => 'Planilla 2',
            'contenido'  => 'Contenido 2',
            'user_id' => $this->user->id,
            'estado'     => 'pendiente',
        ]);

        $response = $this->getJson('/api/planillas?user_id=' . $this->user->id);

        $response->assertStatus(200);
    }

    public function test_create_planilla(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/planillas', [
            'titulo'     => 'Planilla de Prueba',
            'contenido'  => 'Este es el contenido de la planilla.',
            'user_id' => $this->user->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'titulo', 'contenido', 'user_id', 'estado', 'created_at', 'updated_at'])
            ->assertJsonPath('titulo', 'Planilla de Prueba')
            ->assertJsonPath('estado', 'borrador');

        $this->assertDatabaseHas('planillas', ['titulo' => 'Planilla de Prueba']);
    }

    public function test_create_planilla_with_directores(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/planillas', [
            'titulo'     => 'Planilla con Director',
            'contenido'  => 'Contenido con director.',
            'user_id' => $this->user->id,
            'directores' => [$this->director->id],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('planilla_destinatarios', [
            'director_id' => $this->director->id,
        ]);
    }

    public function test_update_planilla(): void
    {
        $this->actingAs($this->user);

        $planilla = Planilla::create([
            'titulo'     => 'Planilla Original',
            'contenido'  => 'Contenido original.',
            'user_id' => $this->user->id,
            'estado'     => 'borrador',
        ]);

        $response = $this->putJson("/api/planillas/{$planilla->id}", [
            'titulo' => 'Planilla Actualizada',
            'estado' => 'pendiente',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('titulo', 'Planilla Actualizada');
    }

    public function test_get_received_planillas(): void
    {
        $planilla = Planilla::create([
            'titulo'     => 'Planilla para Revisión',
            'contenido'  => 'Contenido a revisar.',
            'user_id' => $this->user->id,
            'estado'     => 'pendiente',
        ]);

        PlanillaDestinatario::create([
            'planilla_id' => $planilla->id,
            'director_id' => $this->director->id,
        ]);

        $this->actingAs($this->director);

        $response = $this->getJson('/api/planillas-recibidas');

        $response->assertStatus(200);
    }

    public function test_submit_revision(): void
    {
        $planilla = Planilla::create([
            'titulo'     => 'Planilla para Revisar',
            'contenido'  => 'Contenido a revisar.',
            'user_id' => $this->user->id,
            'estado'     => 'pendiente',
        ]);

        PlanillaDestinatario::create([
            'planilla_id' => $planilla->id,
            'director_id' => $this->director->id,
        ]);

        $this->actingAs($this->director);

        $response = $this->putJson("/api/planillas/{$planilla->id}/revision", [
            'estado'     => 'aprobado',
            'comentario' => 'Planilla aprobada.',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('estado', 'aprobado');
    }

    public function test_create_planilla_validation_fails(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/planillas', [
            'titulo'     => '',
            'contenido'  => '',
            'user_id' => 99999,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['titulo', 'contenido', 'user_id']);
    }

    public function test_revision_without_being_destinatario_fails(): void
    {
        $planilla = Planilla::create([
            'titulo'     => 'Planilla',
            'contenido'  => 'Contenido.',
            'user_id' => $this->user->id,
            'estado'     => 'pendiente',
        ]);

        $this->actingAs($this->director);

        $response = $this->putJson("/api/planillas/{$planilla->id}/revision", [
            'estado' => 'aprobado',
        ]);

        $response->assertStatus(422);
    }

    public function test_unauthenticated_access_returns_401(): void
    {
        $response = $this->getJson('/api/planillas');

        $response->assertStatus(401);
    }
}
