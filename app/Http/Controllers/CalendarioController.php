<?php

namespace App\Http\Controllers;

use App\Http\Resources\CalendarioEventoResource;
use App\Models\Assignment;
use App\Models\Deadline;
use App\Models\PlanificacionAnual;
use App\Models\PlanificacionDiaria;
use App\Traits\ResolvesPersonaCargoCursadoIds;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    use ResolvesPersonaCargoCursadoIds;

    public function index(): JsonResponse
    {
        $user = Auth::user();

        $personaCargoCursadosIds = $this->getPersonaCargoCursadoIds($user);

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
            $entregas = Deadline::with(['assignments.user'])
                ->where('director_id', $user->id)
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
