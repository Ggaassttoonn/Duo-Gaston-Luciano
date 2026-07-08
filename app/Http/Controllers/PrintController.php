<?php

namespace App\Http\Controllers;

use App\Models\PlanificacionDiaria;
use App\Models\PlanificacionAnual;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrintController extends Controller
{
    public function diaria(Request $request, int $id)
    {
        $planificacion = PlanificacionDiaria::with([
            'personaCargoCursado.personaCargo.persona',
            'personaCargoCursado.personaCargo.cargo',
            'personaCargoCursado.personaCargo.sitRevista',
            'personaCargoCursado.cursado.curso',
            'estadosDiarios',
        ])->find($id);

        if (!$planificacion) {
            throw new NotFoundHttpException('Planificación diaria no encontrada.');
        }

        return view('prints.planificacion-diaria', compact('planificacion'));
    }

    public function anual(Request $request, int $id)
    {
        $planificacion = PlanificacionAnual::with([
            'area',
            'personaCargoCursado.personaCargo.persona',
            'personaCargoCursado.personaCargo.cargo',
            'personaCargoCursado.personaCargo.sitRevista',
            'personaCargoCursado.cursado.curso',
            'estadosAnuales',
        ])->find($id);

        if (!$planificacion) {
            throw new NotFoundHttpException('Planificación anual no encontrada.');
        }

        return view('prints.planificacion-anual', compact('planificacion'));
    }
}
