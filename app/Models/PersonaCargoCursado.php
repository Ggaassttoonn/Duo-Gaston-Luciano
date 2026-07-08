<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonaCargoCursado extends Model
{
    protected $table = 'persona_cargo_cursado';

    protected $fillable = [
        'persona_cargos_id',
        'cursado_id',
    ];

    public function personaCargo(): BelongsTo
    {
        return $this->belongsTo(PersonaCargo::class, 'persona_cargos_id');
    }

    public function cursado(): BelongsTo
    {
        return $this->belongsTo(Cursado::class, 'cursado_id');
    }

    public function planificacionesAnuales(): HasMany
    {
        return $this->hasMany(PlanificacionAnual::class, 'persona_cargo_cursado_id');
    }

    public function planificacionesDiarias(): HasMany
    {
        return $this->hasMany(PlanificacionDiaria::class, 'persona_cargo_cursado_id');
    }
}
