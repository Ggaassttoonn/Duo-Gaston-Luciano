<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CursadoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstadoAnualController;
use App\Http\Controllers\EstadoDiariaController;
use App\Http\Controllers\PersonaCargoController;
use App\Http\Controllers\PersonaCargoCursadoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PlanificacionAnualController;
use App\Http\Controllers\PlanificacionDiariaController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\SitRevistaController;
use App\Models\Users;

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me');
    Route::put('/auth/profile', [AuthController::class, 'updateProfile'])->name('auth.profile');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/users', function () {
        return \App\Models\Users::select('id', 'name', 'email', 'role', 'created_at')->get();
    });

    Route::delete('/users/{id}', function ($id) {
        $user = \App\Models\Users::findOrFail($id);
        if ($user->role === 'admin') {
            return response()->json(['message' => 'No se puede eliminar un administrador.'], 403);
        }
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    });

    Route::put('/users/{id}/role', function (\Illuminate\Http\Request $request, $id) {
        $user = \App\Models\Users::findOrFail($id);
        if ($user->role === 'admin') {
            return response()->json(['message' => 'No se puede cambiar el rol de un administrador.'], 403);
        }
        $user->role = $request->input('role');
        $user->save();
        return response()->json(['message' => 'Rol actualizado correctamente.']);
    });

    Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
    Route::post('/planillas', [PlanillaController::class, 'store'])->name('planillas.store');
    Route::put('/planillas/{id}', [PlanillaController::class, 'update'])->name('planillas.update');
    Route::get('/planillas-recibidas', [PlanillaController::class, 'recibidas'])->name('planillas.recibidas');
    Route::put('/planillas/{id}/revision', [PlanillaController::class, 'revision'])->name('planillas.revision');
});

// Listado de áreas (index) -> renderiza areas.index
Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');

// Formulario para crear área (create) -> renderiza areas.create
Route::get('/areas/create', [AreaController::class, 'create'])->name('areas.create');

// Guardar nueva área (store) -> procesa el formulario y redirige
Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');

// Mostrar un área específica (show) -> {area} es el ID que Eloquent inyecta automáticamente
Route::get('/areas/{area}', [AreaController::class, 'show'])->name('areas.show');

// Formulario para editar (edit) -> renderiza areas.edit pasándole el modelo
Route::get('/areas/{area}/edit', [AreaController::class, 'edit'])->name('areas.edit');

// Actualizar área (update) -> procesa los cambios del formulario
Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');

// Eliminar área (destroy) -> borra el registro de la base de datos
Route::delete('/areas/{area}', [AreaController::class, 'destroy'])->name('areas.destroy');

// Rutas para Cargos
Route::get('/cargos', [CargoController::class, 'index'])->name('cargos.index');
Route::get('/cargos/create', [CargoController::class, 'create'])->name('cargos.create');
Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store');
Route::get('/cargos/{cargo}', [CargoController::class, 'show'])->name('cargos.show');
Route::get('/cargos/{cargo}/edit', [CargoController::class, 'edit'])->name('cargos.edit');
Route::put('/cargos/{cargo}', [CargoController::class, 'update'])->name('cargos.update');
Route::delete('/cargos/{cargo}', [CargoController::class, 'destroy'])->name('cargos.destroy');

// Rutas para Persona-Cargos
Route::get('/persona-cargos', [PersonaCargoController::class, 'index'])->name('persona-cargos.index');
Route::get('/persona-cargos/create', [PersonaCargoController::class, 'create'])->name('persona-cargos.create');
Route::post('/persona-cargos', [PersonaCargoController::class, 'store'])->name('persona-cargos.store');
Route::get('/persona-cargos/{personaCargo}', [PersonaCargoController::class, 'show'])->name('persona-cargos.show');
Route::get('/persona-cargos/{personaCargo}/edit', [PersonaCargoController::class, 'edit'])->name('persona-cargos.edit');
Route::put('/persona-cargos/{personaCargo}', [PersonaCargoController::class, 'update'])->name('persona-cargos.update');
Route::delete('/persona-cargos/{personaCargo}', [PersonaCargoController::class, 'destroy'])->name('persona-cargos.destroy');

// Rutas para Personas
Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');
Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
Route::get('/personas/{persona}', [PersonaController::class, 'show'])->name('personas.show');
Route::get('/personas/{persona}/edit', [PersonaController::class, 'edit'])->name('personas.edit');
Route::put('/personas/{persona}', [PersonaController::class, 'update'])->name('personas.update');
Route::delete('/personas/{persona}', [PersonaController::class, 'destroy'])->name('personas.destroy');

// Rutas para Situaciones de Revista
Route::get('/sit-revistas', [SitRevistaController::class, 'index'])->name('sit-revistas.index');
Route::get('/sit-revistas/create', [SitRevistaController::class, 'create'])->name('sit-revistas.create');
Route::post('/sit-revistas', [SitRevistaController::class, 'store'])->name('sit-revistas.store');
Route::get('/sit-revistas/{sitRevista}', [SitRevistaController::class, 'show'])->name('sit-revistas.show');
Route::get('/sit-revistas/{sitRevista}/edit', [SitRevistaController::class, 'edit'])->name('sit-revistas.edit');
Route::put('/sit-revistas/{sitRevista}', [SitRevistaController::class, 'update'])->name('sit-revistas.update');
Route::delete('/sit-revistas/{sitRevista}', [SitRevistaController::class, 'destroy'])->name('sit-revistas.destroy');

// Rutas para Planificaciones Diarias
Route::get('/planificaciones-diarias', [PlanificacionDiariaController::class, 'index'])->name('planificaciones-diarias.index');
Route::get('/planificaciones-diarias/create', [PlanificacionDiariaController::class, 'create'])->name('planificaciones-diarias.create');
Route::post('/planificaciones-diarias', [PlanificacionDiariaController::class, 'store'])->name('planificaciones-diarias.store');
Route::get('/planificaciones-diarias/{planificacionDiaria}', [PlanificacionDiariaController::class, 'show'])->name('planificaciones-diarias.show');
Route::get('/planificaciones-diarias/{planificacionDiaria}/edit', [PlanificacionDiariaController::class, 'edit'])->name('planificaciones-diarias.edit');
Route::put('/planificaciones-diarias/{planificacionDiaria}', [PlanificacionDiariaController::class, 'update'])->name('planificaciones-diarias.update');
Route::delete('/planificaciones-diarias/{planificacionDiaria}', [PlanificacionDiariaController::class, 'destroy'])->name('planificaciones-diarias.destroy');

// Rutas para Planificaciones Anuales
Route::get('/planificaciones-anuales', [PlanificacionAnualController::class, 'index'])->name('planificaciones-anuales.index');
Route::get('/planificaciones-anuales/create', [PlanificacionAnualController::class, 'create'])->name('planificaciones-anuales.create');
Route::post('/planificaciones-anuales', [PlanificacionAnualController::class, 'store'])->name('planificaciones-anuales.store');
Route::get('/planificaciones-anuales/{planificacionAnual}', [PlanificacionAnualController::class, 'show'])->name('planificaciones-anuales.show');
Route::get('/planificaciones-anuales/{planificacionAnual}/edit', [PlanificacionAnualController::class, 'edit'])->name('planificaciones-anuales.edit');
Route::put('/planificaciones-anuales/{planificacionAnual}', [PlanificacionAnualController::class, 'update'])->name('planificaciones-anuales.update');
Route::delete('/planificaciones-anuales/{planificacionAnual}', [PlanificacionAnualController::class, 'destroy'])->name('planificaciones-anuales.destroy');

// Rutas para Persona-Cargo-Cursados
Route::get('/persona-cargo-cursados', [PersonaCargoCursadoController::class, 'index'])->name('persona-cargo-cursados.index');
Route::get('/persona-cargo-cursados/create', [PersonaCargoCursadoController::class, 'create'])->name('persona-cargo-cursados.create');
Route::post('/persona-cargo-cursados', [PersonaCargoCursadoController::class, 'store'])->name('persona-cargo-cursados.store');
Route::get('/persona-cargo-cursados/{personaCargoCursado}', [PersonaCargoCursadoController::class, 'show'])->name('persona-cargo-cursados.show');
Route::get('/persona-cargo-cursados/{personaCargoCursado}/edit', [PersonaCargoCursadoController::class, 'edit'])->name('persona-cargo-cursados.edit');
Route::put('/persona-cargo-cursados/{personaCargoCursado}', [PersonaCargoCursadoController::class, 'update'])->name('persona-cargo-cursados.update');
Route::delete('/persona-cargo-cursados/{personaCargoCursado}', [PersonaCargoCursadoController::class, 'destroy'])->name('persona-cargo-cursados.destroy');

// Rutas para Estados Diarios
Route::get('/estados-diarias', [EstadoDiariaController::class, 'index'])->name('estados-diarias.index');
Route::get('/estados-diarias/create', [EstadoDiariaController::class, 'create'])->name('estados-diarias.create');
Route::post('/estados-diarias', [EstadoDiariaController::class, 'store'])->name('estados-diarias.store');
Route::get('/estados-diarias/{estadoDiaria}', [EstadoDiariaController::class, 'show'])->name('estados-diarias.show');
Route::get('/estados-diarias/{estadoDiaria}/edit', [EstadoDiariaController::class, 'edit'])->name('estados-diarias.edit');
Route::put('/estados-diarias/{estadoDiaria}', [EstadoDiariaController::class, 'update'])->name('estados-diarias.update');
Route::delete('/estados-diarias/{estadoDiaria}', [EstadoDiariaController::class, 'destroy'])->name('estados-diarias.destroy');

// Rutas para Cursados
Route::get('/cursados', [CursadoController::class, 'index'])->name('cursados.index');
Route::get('/cursados/create', [CursadoController::class, 'create'])->name('cursados.create');
Route::post('/cursados', [CursadoController::class, 'store'])->name('cursados.store');
Route::get('/cursados/{cursado}', [CursadoController::class, 'show'])->name('cursados.show');
Route::get('/cursados/{cursado}/edit', [CursadoController::class, 'edit'])->name('cursados.edit');
Route::put('/cursados/{cursado}', [CursadoController::class, 'update'])->name('cursados.update');
Route::delete('/cursados/{cursado}', [CursadoController::class, 'destroy'])->name('cursados.destroy');

// Rutas para Estados Anuales
Route::get('/estados-anuales', [EstadoAnualController::class, 'index'])->name('estados-anuales.index');
Route::get('/estados-anuales/create', [EstadoAnualController::class, 'create'])->name('estados-anuales.create');
Route::post('/estados-anuales', [EstadoAnualController::class, 'store'])->name('estados-anuales.store');
Route::get('/estados-anuales/{estadoAnual}', [EstadoAnualController::class, 'show'])->name('estados-anuales.show');
Route::get('/estados-anuales/{estadoAnual}/edit', [EstadoAnualController::class, 'edit'])->name('estados-anuales.edit');
Route::put('/estados-anuales/{estadoAnual}', [EstadoAnualController::class, 'update'])->name('estados-anuales.update');
Route::delete('/estados-anuales/{estadoAnual}', [EstadoAnualController::class, 'destroy'])->name('estados-anuales.destroy');

// Rutas para Cursos
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');
Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');