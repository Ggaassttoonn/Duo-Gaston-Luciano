<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanificacionDiaria;
use App\Models\EstadoDiaria; // <-- Asegúrate de que tu modelo se llame así

class EstadoDiariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Traemos todas las planificaciones diarias de la base de datos
        $planificaciones = PlanificacionDiaria::all();

        if ($planificaciones->isEmpty()) {
            return;
        }

        // 2. Recorremos cada planificación para asignarle su historial de estados
        foreach ($planificaciones as $index => $planificacion) {

            // Simulación Flujo 1: Planificaciones más viejas ya pasaron por todo el circuito
            if ($index % 3 == 0) {
                // Primero el docente la presentó
                EstadoDiaria::create([
                    'estado' => 'Presentado',
                    'fecha' => '2026-03-20',
                    'planificacion_diaria_id' => $planificacion->id,
                ]);

                // Luego el directivo la aprobó un par de días después
                EstadoDiaria::create([
                    'estado' => 'Aprobado',
                    'fecha' => '2026-03-22',
                    'planificacion_diaria_id' => $planificacion->id,
                ]);
            }

            // Simulación Flujo 2: Planificaciones intermedias que necesitan corrección
            elseif ($index % 3 == 1) {
                EstadoDiaria::create([
                    'estado' => 'Presentado',
                    'fecha' => '2026-03-20',
                    'planificacion_diaria_id' => $planificacion->id,
                ]);

                EstadoDiaria::create([
                    'estado' => 'A corregir',
                    'fecha' => '2026-03-21',
                    'planificacion_diaria_id' => $planificacion->id,
                ]);
            }

            // Simulación Flujo 3: Planificaciones nuevas que acaban de ser enviadas
            else {
                EstadoDiaria::create([
                    'estado' => 'Presentado',
                    'fecha' => '2026-03-23',
                    'planificacion_diaria_id' => $planificacion->id,
                ]);
            }
        }
    }
}
