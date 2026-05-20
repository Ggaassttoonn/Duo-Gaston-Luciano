<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonaCargoCursado;
use App\Models\PlanificacionDiaria; // <-- Asegúrate de tener este modelo creado

class PlanificacionDiariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buscamos las asignaciones de maestros en aulas
        $asignaciones = PersonaCargoCursado::all();

        if ($asignaciones->isEmpty()) {
            return;
        }

        // 2. Recorremos los maestros y les creamos planificaciones para dos días seguidos
        foreach ($asignaciones as $asignacion) {

            // --- DÍA 1 (Ejemplo: Lunes de clases) ---
            PlanificacionDiaria::create([
                'fecha_presentacion' => '2026-03-20',
                'fecha_estimada'     => '2026-03-23', // Fecha planeada para dar la clase
                'fecha_desarrollada' => '2026-03-23', // Fecha en la que efectivamente se dictó

                'contenidos_especificos' => 'Comprensión lectora. El cuento maravilloso: estructura (inicio, nudo y desenlace). Identificación de personajes principales y secundarios.',

                'actividades' => '1. Lectura colectiva en voz alta del cuento "El sastrecillo valiente".' . "\n" .
                    '2. Debate guiado sobre las decisiones del protagonista.' . "\n" .
                    '3. Trabajo en parejas: completar un cuadro sinóptico identificando la introducción, el conflicto y la resolución del relato.',

                'tareas' => 'Responder en el cuaderno: ¿Qué harías tú si estuvieras en el lugar del protagonista? Dibujar la escena que más te gustó del cuento.',

                'persona_cargo_cursado_id' => $asignacion->id,
                'tipo_planificacion'       => 'Clase Diaria Ordinaria',
            ]);

            // --- DÍA 2 (Ejemplo: Martes de clases) ---
            PlanificacionDiaria::create([
                'fecha_presentacion' => '2026-03-20',
                'fecha_estimada'     => '2026-03-24',
                'fecha_desarrollada' => '2026-03-24',

                'contenidos_especificos' => 'Estrategias de cálculo mental para sumas y restas complejas. Uso del sistema posicional para desarmar números.',

                'actividades' => '1. Juego matemático en el pizarrón: "Adivina el número oculto" desarmando unidades, decenas y centenas.' . "\n" .
                    '2. Resolución individual de situaciones problemáticas de compra y venta simuladas en un almacén.' . "\n" .
                    '3. Puesta en común de las diferentes estrategias utilizadas por los alumnos.',

                'tareas' => 'Resolver las actividades de la página 14 del libro de matemática integrado.',

                'persona_cargo_cursado_id' => $asignacion->id,
                'tipo_planificacion'       => 'Clase Diaria Ordinaria',
            ]);
        }
    }
}
