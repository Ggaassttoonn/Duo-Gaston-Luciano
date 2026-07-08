<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cursado extends Model
{
    protected $fillable = [
        'anio_lectivo',
        'fecha_inicio',
        'fecha_fin',
        'curso_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function personaCargoCursados(): HasMany
    {
        return $this->hasMany(PersonaCargoCursado::class, 'cursado_id');
    }
}
