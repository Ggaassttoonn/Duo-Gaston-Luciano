<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanificacionDiaria extends Model
{
    protected $table = 'planificacion_diaria';

    protected $fillable = [
        'fecha_estimada',
        'fecha_desarrollada',
        'fecha_presentacion',
        'contenidos_especificos',
        'actividades',
        'tareas',
        'persona_cargo_cursado_id',
        'tipo_planificacion',
    ];

    protected $casts = [
        'fecha_estimada' => 'date',
        'fecha_desarrollada' => 'date',
        'fecha_presentacion' => 'date',
    ];

    public function personaCargoCursado(): BelongsTo
    {
        return $this->belongsTo(PersonaCargoCursado::class, 'persona_cargo_cursado_id');
    }

    public function estadosDiarios(): HasMany
    {
        return $this->hasMany(EstadoDiaria::class, 'planificacion_diaria_id');
    }
}
