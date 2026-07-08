<?php

namespace App\Http\Resources;

use App\Models\Assignment;
use App\Models\Deadline;
use App\Models\PlanificacionAnual;
use App\Models\PlanificacionDiaria;
use Illuminate\Http\Request;

class CalendarioEventoResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof PlanificacionDiaria) {
            return $this->toArrayDiaria();
        }

        if ($this->resource instanceof PlanificacionAnual) {
            return $this->toArrayAnual();
        }

        if ($this->resource instanceof Deadline) {
            return $this->toArrayDeadline();
        }

        return $this->toArrayAssignment();
    }

    private function toArrayDiaria(): array
    {
        $ultimoEstado = $this->estadosDiarios?->last();

        return [
            'id' => $this->id,
            'title' => $this->tipo_planificacion ?? 'Planificación Diaria',
            'start' => $this->fecha_estimada?->format('Y-m-d'),
            'end' => $this->fecha_desarrollada?->format('Y-m-d') ?? $this->fecha_estimada?->format('Y-m-d'),
            'allDay' => true,
            'tipo' => 'diaria',
            'color' => $this->calcularColor($ultimoEstado?->estado),
            'estado' => $ultimoEstado?->estado,
            'fecha_estimada' => $this->fecha_estimada?->format('Y-m-d'),
            'fecha_desarrollada' => $this->fecha_desarrollada?->format('Y-m-d'),
            'fecha_presentacion' => $this->fecha_presentacion?->format('Y-m-d'),
            'contenidos_especificos' => $this->contenidos_especificos,
            'actividades' => $this->actividades,
            'tareas' => $this->tareas,
            'persona_cargo_cursado_id' => $this->persona_cargo_cursado_id,
            'tipo_planificacion' => $this->tipo_planificacion,
            'persona_cargo_cursado' => PersonaCargoCursadoResource::make($this->whenLoaded('personaCargoCursado')),
            'estados_diarios' => EstadoDiariaResource::collection($this->whenLoaded('estadosDiarios')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    private function toArrayAnual(): array
    {
        $ultimoEstado = $this->estadosAnuales?->last();

        return [
            'id' => $this->id,
            'title' => $this->area?->area ?? $this->tipo_planificacion ?? 'Planificación Anual',
            'start' => $this->fecha_presentacion?->format('Y-m-d'),
            'end' => $this->fecha_presentacion?->format('Y-m-d'),
            'allDay' => true,
            'tipo' => 'anual',
            'color' => $this->calcularColor($ultimoEstado?->estado),
            'estado' => $ultimoEstado?->estado,
            'fecha_presentacion' => $this->fecha_presentacion?->format('Y-m-d'),
            'aprendizajes_esperados' => $this->aprendizajes_esperados,
            'saberes' => $this->saberes,
            'criterios' => $this->criterios,
            'bibliografia' => $this->bibliografia,
            'diagnostico' => $this->diagnostico,
            'area_id' => $this->area_id,
            'persona_cargo_cursado_id' => $this->persona_cargo_cursado_id,
            'tipo_planificacion' => $this->tipo_planificacion,
            'area' => AreaResource::make($this->whenLoaded('area')),
            'persona_cargo_cursado' => PersonaCargoCursadoResource::make($this->whenLoaded('personaCargoCursado')),
            'estados_anuales' => EstadoAnualResource::collection($this->whenLoaded('estadosAnuales')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    private function toArrayDeadline(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->titulo,
            'start' => $this->fecha_limite?->format('Y-m-d'),
            'end' => $this->fecha_limite?->format('Y-m-d'),
            'allDay' => true,
            'tipo' => 'deadline',
            'color' => '#F59E0B',
            'descripcion' => $this->descripcion,
            'fecha_limite' => $this->fecha_limite?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    private function toArrayAssignment(): array
    {
        $statusColors = [
            'pending'   => '#F59E0B',
            'submitted' => '#3B82F6',
            'approved'  => '#10B981',
        ];

        return [
            'id' => $this->id,
            'deadline_id' => $this->deadline_id,
            'title' => $this->deadline->titulo,
            'start' => $this->deadline->fecha_limite?->format('Y-m-d'),
            'end' => $this->deadline->fecha_limite?->format('Y-m-d'),
            'allDay' => true,
            'tipo' => 'assignment',
            'color' => $statusColors[$this->status] ?? '#6B7280',
            'status' => $this->status,
            'descripcion' => $this->deadline->descripcion,
            'fecha_limite' => $this->deadline->fecha_limite?->toISOString(),
            'respuesta' => $this->respuesta,
            'submitted_at' => $this->submitted_at?->toISOString(),
            'director' => $this->whenLoaded('deadline', function () {
                return [
                    'id' => $this->deadline->director?->id,
                    'name' => $this->deadline->director?->name,
                ];
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    private function calcularColor(?string $estado): string
    {
        return match ($estado) {
            'presentado'    => '#3B82F6',
            'aprobado'      => '#10B981',
            'rechazado'     => '#EF4444',
            'pendiente'     => '#F59E0B',
            'borrador'      => '#6B7280',
            'en_revision'   => '#8B5CF6',
            default         => '#6B7280',
        };
    }
}
