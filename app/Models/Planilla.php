<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planilla extends Model
{
    protected $fillable = [
        'titulo',
        'contenido',
        'persona_id',
        'estado',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'persona_id');
    }

    public function destinatarios(): HasMany
    {
        return $this->hasMany(PlanillaDestinatario::class, 'planilla_id');
    }
}
