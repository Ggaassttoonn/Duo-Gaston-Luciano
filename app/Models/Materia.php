<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    protected $fillable = [
        'nombre',
        'area_id',
        'primer_ciclo',
        'segundo_ciclo',
        'tercer_ciclo',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function planillas(): HasMany
    {
        return $this->hasMany(Planilla::class, 'materia_id');
    }
}
