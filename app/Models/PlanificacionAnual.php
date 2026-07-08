<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanificacionAnual extends Model
{
    protected $table = 'planificacion_anual';

    protected $fillable = [
        'fecha_presentacion',
        'aprendizajes_esperados',
        'saberes',
        'criterios',
        'bibliografia',
        'diagnostico',
        'area_id',
        'persona_cargo_cursado_id',
        'tipo_planificacion',
    ];

    protected $casts = [
        'fecha_presentacion' => 'date',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function personaCargoCursado(): BelongsTo
    {
        return $this->belongsTo(PersonaCargoCursado::class, 'persona_cargo_cursado_id');
    }

    public function estadosAnuales(): HasMany
    {
        return $this->hasMany(EstadoAnual::class, 'planificacion_anual_id');
    }
}
