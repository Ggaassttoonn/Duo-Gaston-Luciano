<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonaCargoCursado;
use App\Models\Area;
use App\Models\PlanificacionAnual; // <-- Asegúrate de tener este modelo creado

class PlanificacionAnualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Traemos las asignaciones de maestros en las aulas y las materias
        $asignaciones = PersonaCargoCursado::all();
        $areas = Area::all();

        // Control de seguridad por si las tablas previas están vacías
        if ($asignaciones->isEmpty() || $areas->isEmpty()) {
            return;
        }

        // 2. Recorremos las asignaciones para que cada maestro de grado tenga su planificación
        foreach ($asignaciones as $index => $asignacion) {

            // Le asignamos una materia de forma intercalada para variar
            $area = $areas->get($index % $areas->count());

            PlanificacionAnual::create([
                'fecha_presentacion' => '2026-03-15', // Se presenta a inicios del ciclo lectivo

                'diagnostico' => 'El grupo clase muestra un gran entusiasmo por aprender. Se observa heterogeneidad en los ritmos de trabajo. Un 80% del alumnado interpreta consignas simples de manera autónoma, mientras que el resto requiere acompañamiento personalizado.',

                'aprendizajes_esperados' => '• Desarrollar habilidades de pensamiento crítico y resolución de problemas cotidianos.' . "\n" .
                    '• Fortalecer la comprensión lectora y la producción escrita autónoma.' . "\n" .
                    '• Fomentar el trabajo colaborativo y el respeto por las normas de convivencia escolares.',

                'saberes' => 'Eje 1: Comprensión y producción oral. Análisis de textos literarios e informativos.' . "\n" .
                    'Eje 2: Operaciones matemáticas abstractas y geometría aplicada al entorno.' . "\n" .
                    'Eje 3: Reconocimiento del entorno social, histórico y natural regional.',

                'criterios' => '• Participación activa y colaborativa en las tareas áulicas cotidianas.' . "\n" .
                    '• Cumplimiento en tiempo y forma de los proyectos asignados.' . "\n" .
                    '• Capacidad para justificar procedimientos y debatir ideas de forma pacífica.',

                'bibliografia' => '• Diseños Curriculares de la Educación Primaria.' . "\n" .
                    '• Libros escolares de áreas integradas (Ediciones 2025/2026).' . "\n" .
                    '• Material pedagógico provisto por el Ministerio de Educación.',

                'areas_id' => $area->id,
                'persona_cargo_cursado_id' => $asignacion->id,
                'tipo_planificacion' => 'Anual Obligatoria', // O "Ajuste Curricular", "Proyecto Corto", etc.
            ]);
        }
    }
}
