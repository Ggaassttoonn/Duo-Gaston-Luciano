<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanificacionAnual;
use App\Models\EstadoAnual; // <-- Asegúrate de que tu modelo se llame así

class EstadoAnualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Traemos todas las planificaciones anuales
        $planificacionesAnuales = PlanificacionAnual::all();

        if ($planificacionesAnuales->isEmpty()) {
            return;
        }

        // 2. Recorremos y generamos el historial de estados
        foreach ($planificacionesAnuales as $index => $planificacion) {

            // Flujo A: La gran mayoría se presenta y se aprueba rápido en marzo
            if ($index % 4 != 0) {
                EstadoAnual::create([
                    'estado' => 'Presentado',
                    'fecha' => '2026-03-15',
                    'planificacion_anual_id' => $planificacion->id,
                ]);

                EstadoAnual::create([
                    'estado' => 'Aprobado',
                    'fecha' => '2026-03-25',
                    'planificacion_anual_id' => $planificacion->id,
                ]);
            }
            // Flujo B: Algunas quedan observadas para corrección pedagógica
            else {
                EstadoAnual::create([
                    'estado' => 'Presentado',
                    'fecha' => '2026-03-15',
                    'planificacion_anual_id' => $planificacion->id,
                ]);

                EstadoAnual::create([
                    'estado' => 'A corregir',
                    'fecha' => '2026-03-18',
                    'planificacion_anual_id' => $planificacion->id,
                ]);
            }
        }
    }
}
