<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CursadoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstadoAnualController;
use App\Http\Controllers\EstadoDiariaController;
use App\Http\Controllers\MateriaController;
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
use App\Http\Controllers\PrintController;
use App\Http\Controllers\EventoCalendarioController;

Route::get('/health', fn() => response()->json(['status' => 'ok', 'app' => 'BackPlanificar']))->name('health');

Route::get('/setup-admin', function () {
    $adminPersona = \App\Models\Persona::firstOrCreate(
        ['email' => 'admin@admin.com'],
        [
            'apellidos'        => 'Admin',
            'nombres'          => 'Administrador',
            'dni'              => '00000000',
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => '2000-01-01',
        ]
    );

    \App\Models\Users::firstOrCreate(
        ['email' => 'admin@admin.com'],
        [
            'persona_id' => $adminPersona->id,
            'name'       => 'Administrador',
            'email'      => 'admin@admin.com',
            'password'   => 'admin123',
            'role'       => 'admin',
        ]
    );

    $dirPersona = \App\Models\Persona::firstOrCreate(
        ['email' => 'klee54319@gmail.com'],
        [
            'apellidos'        => 'Ggaassttoonn',
            'nombres'          => 'Director',
            'dni'              => '99999999',
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => '2000-01-01',
        ]
    );

    \App\Models\Users::firstOrCreate(
        ['email' => 'klee54319@gmail.com'],
        [
            'persona_id' => $dirPersona->id,
            'name'       => 'Ggaassttoonn',
            'email'      => 'klee54319@gmail.com',
            'password'   => 'admin123',
            'role'       => 'director',
        ]
    );

    return response()->json(['message' => 'Usuarios creados. Admin: admin@admin.com / Director: klee54319@gmail.com / Pass ambos: admin123']);
});

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me');
    Route::get('/auth/profile', [AuthController::class, 'me'])->name('auth.profile.show');
    Route::put('/auth/profile', [AuthController::class, 'updateProfile'])->name('auth.profile');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/auth/preferences', [AuthController::class, 'getPreferences'])->name('auth.preferences');
    Route::put('/auth/preferences', [AuthController::class, 'updatePreferences'])->name('auth.preferences.update');

    Route::get('/users', function (Request $request) {
        $users = Users::select('id', 'name', 'email', 'role', 'foto', 'persona_id', 'created_at')->get();
        $host = $request->getSchemeAndHttpHost();
        $users->each(function ($user) use ($host) {
            if ($user->foto && str_starts_with($user->foto, 'http://localhost')) {
                $user->foto = str_replace(['http://localhost:8000', 'http://localhost'], $host, $user->foto);
            }
        });
        return $users;
    });

    Route::get('/users/{id}/photo', function ($id) {
        $user = Users::findOrFail($id);
        return response()->json(['foto' => $user->foto]);
    });

    Route::delete('/users/{id}', function (Request $request, $id) {
        $authUser = $request->user();
        if (!in_array($authUser->role, ['admin', 'director'])) {
            return response()->json(['message' => 'Solo los administradores pueden eliminar usuarios.'], 403);
        }

        $targetUser = Users::findOrFail($id);
        if (in_array($targetUser->role, ['admin', 'director'])) {
            return response()->json(['message' => 'No se puede eliminar a otro administrador.'], 403);
        }

        $targetUser->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    });

    Route::put('/users/{id}/role', function (Request $request, $id) {
        $authUser = $request->user();
        if (!in_array($authUser->role, ['admin', 'director'])) {
            return response()->json(['message' => 'Solo los administradores pueden cambiar roles.'], 403);
        }

        $targetUser = Users::findOrFail($id);
        if (in_array($targetUser->role, ['admin', 'director'])) {
            return response()->json(['message' => 'No se puede cambiar el rol de otro administrador.'], 403);
        }

        $validated = $request->validate(['role' => 'required|string|in:docente,admin,director']);
        $targetUser->role = $validated['role'];
        $targetUser->save();
        return response()->json(['message' => 'Rol actualizado correctamente.', 'user' => $targetUser], 200);
    });

    Route::get('/planillas', [PlanillaController::class, 'index'])->name('planillas.index');
    Route::post('/planillas', [PlanillaController::class, 'store'])->name('planillas.store');
    Route::put('/planillas/{planilla}', [PlanillaController::class, 'update'])->name('planillas.update');
    Route::get('/planillas-recibidas', [PlanillaController::class, 'recibidas'])->name('planillas.recibidas');
    Route::put('/planillas/{planilla}/revision', [PlanillaController::class, 'revision'])->name('planillas.revision');
    Route::delete('/planillas/{planilla}', [PlanillaController::class, 'destroy'])->name('planillas.destroy');

    Route::apiResource('areas', AreaController::class);
    Route::apiResource('cargos', CargoController::class);
    Route::apiResource('persona-cargos', PersonaCargoController::class);
    Route::apiResource('personas', PersonaController::class);
    Route::apiResource('sit-revistas', SitRevistaController::class);
    Route::apiResource('planificaciones-diarias', PlanificacionDiariaController::class);
    Route::apiResource('planificaciones-anuales', PlanificacionAnualController::class);
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');

    Route::get('/deadlines', [DeadlineController::class, 'index'])->name('deadlines.index');
    Route::post('/deadlines', [DeadlineController::class, 'store'])->name('deadlines.store');
    Route::get('/deadlines/{deadline}', [DeadlineController::class, 'show'])->name('deadlines.show');
    Route::put('/deadlines/{deadline}', [DeadlineController::class, 'update'])->name('deadlines.update');
    Route::delete('/deadlines/{deadline}', [DeadlineController::class, 'destroy'])->name('deadlines.destroy');

    Route::get('/deadlines/{deadline}/assignments', [AssignmentController::class, 'getAssignments'])->name('deadlines.assignments');
    Route::patch('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::get('/my-assignments', [AssignmentController::class, 'getMyAssignments'])->name('assignments.my');

    Route::apiResource('persona-cargo-cursados', PersonaCargoCursadoController::class);
    Route::apiResource('estados-diarias', EstadoDiariaController::class);
    Route::apiResource('cursados', CursadoController::class);
    Route::apiResource('estados-anuales', EstadoAnualController::class);
    Route::apiResource('cursos', CursoController::class);
    Route::apiResource('materias', MateriaController::class);

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

    Route::get('/planificaciones-diarias/{id}/print', [PrintController::class, 'diaria'])->name('planificaciones.diarias.print');
    Route::get('/planificaciones-anuales/{id}/print', [PrintController::class, 'anual'])->name('planificaciones.anuales.print');

    Route::get('/eventos-calendario', [EventoCalendarioController::class, 'index']);
    Route::post('/eventos-calendario', [EventoCalendarioController::class, 'store']);
    Route::put('/eventos-calendario/{eventoCalendario}', [EventoCalendarioController::class, 'update']);
    Route::delete('/eventos-calendario/{eventoCalendario}', [EventoCalendarioController::class, 'destroy']);
});
