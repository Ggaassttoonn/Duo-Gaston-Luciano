<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarioEventoResource;
use App\Models\Assignment;
use App\Models\Deadline;
use App\Models\PlanificacionAnual;
use App\Models\PlanificacionDiaria;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $personaCargoCursadosIds = $user->persona
            ->cargos()
            ->with('personaCargoCursados')
            ->get()
            ->pluck('personaCargoCursados')
            ->flatten()
            ->pluck('id')
            ->unique();

        $diarias = PlanificacionDiaria::with([
            'estadosDiarios',
            'personaCargoCursado.cursado.curso',
            'personaCargoCursado.personaCargo.persona',
        ])
            ->whereIn('persona_cargo_cursado_id', $personaCargoCursadosIds)
            ->orderBy('fecha_estimada')
            ->get();

        $anuales = PlanificacionAnual::with([
            'estadosAnuales',
            'area',
            'personaCargoCursado.cursado.curso',
            'personaCargoCursado.personaCargo.persona',
        ])
            ->whereIn('persona_cargo_cursado_id', $personaCargoCursadosIds)
            ->orderBy('fecha_presentacion')
            ->get();

        if (in_array($user->role, ['admin', 'director'], true)) {
            $entregas = Deadline::where('director_id', $user->id)
                ->orderBy('fecha_limite')
                ->get();
        } else {
            $entregas = Assignment::with(['deadline.director'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $eventos = $diarias->merge($anuales)->merge($entregas);

        return CalendarioEventoResource::collection($eventos)->response();
    }
}
