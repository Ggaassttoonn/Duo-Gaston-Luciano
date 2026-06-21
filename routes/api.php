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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlanillaRevisionController;
use App\Http\Controllers\PlanillaStateController;
use App\Http\Controllers\SentReportController;
use App\Http\Controllers\EventoCalendarioController;

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me');
    Route::put('/auth/profile', [AuthController::class, 'updateProfile'])->name('auth.profile');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/auth/preferences', [AuthController::class, 'getPreferences'])->name('auth.preferences');
    Route::put('/auth/preferences', [AuthController::class, 'updatePreferences'])->name('auth.preferences.update');

    Route::get('/users', function () {
        return Users::select('id', 'name', 'email', 'role', 'foto', 'persona_id', 'created_at')->get();
    });

    Route::get('/users/{id}/photo', function ($id) {
        $user = Users::findOrFail($id);
        return response()->json(['foto' => $user->foto]);
    });

    Route::delete('/users/{id}', function ($id) {
        $user = Users::findOrFail($id);
        if ($user->role === 'admin') {
            return response()->json(['message' => 'No se puede eliminar un administrador.'], 403);
        }
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    });

    Route::put('/users/{id}/role', function (Request $request, $id) {
        $user = Users::findOrFail($id);
        if ($user->role === 'admin') {
            return response()->json(['message' => 'No se puede cambiar el rol de un administrador.'], 403);
        }
        $user->role = $request->input('role');
        $user->save();
        return response()->json(['message' => 'Rol actualizado correctamente.'], 200);
    });

    Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
    Route::post('/planillas', [PlanillaController::class, 'store'])->name('planillas.store');
    Route::put('/planillas/{planilla}', [PlanillaController::class, 'update'])->name('planillas.update');
    Route::get('/planillas-recibidas', [PlanillaController::class, 'recibidas'])->name('planillas.recibidas');
    Route::put('/planillas/{planilla}/revision', [PlanillaController::class, 'revision'])->name('planillas.revision');

    Route::apiResource('areas', AreaController::class);
    Route::apiResource('cargos', CargoController::class);
    Route::apiResource('persona-cargos', PersonaCargoController::class);
    Route::apiResource('personas', PersonaController::class);
    Route::apiResource('sit-revistas', SitRevistaController::class);
    Route::apiResource('planificaciones-diarias', PlanificacionDiariaController::class);
    Route::apiResource('planificaciones-anuales', PlanificacionAnualController::class);
    Route::apiResource('persona-cargo-cursados', PersonaCargoCursadoController::class);
    Route::apiResource('estados-diarias', EstadoDiariaController::class);
    Route::apiResource('cursados', CursadoController::class);
    Route::apiResource('estados-anuales', EstadoAnualController::class);
    Route::apiResource('cursos', CursoController::class);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead']);
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);

    Route::get('/revisions', [PlanillaRevisionController::class, 'index']);
    Route::post('/revisions', [PlanillaRevisionController::class, 'store']);

    Route::get('/planilla-states', [PlanillaStateController::class, 'index']);
    Route::post('/planilla-states', [PlanillaStateController::class, 'store']);

    Route::get('/sent-reports', [SentReportController::class, 'index']);
    Route::post('/sent-reports', [SentReportController::class, 'store']);

    Route::get('/eventos-calendario', [EventoCalendarioController::class, 'index']);
    Route::post('/eventos-calendario', [EventoCalendarioController::class, 'store']);
    Route::put('/eventos-calendario/{eventoCalendario}', [EventoCalendarioController::class, 'update']);
    Route::delete('/eventos-calendario/{eventoCalendario}', [EventoCalendarioController::class, 'destroy']);




});
