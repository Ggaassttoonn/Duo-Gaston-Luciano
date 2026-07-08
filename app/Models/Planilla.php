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
        'user_id',
        'estado',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function destinatarios(): HasMany
    {
        return $this->hasMany(PlanillaDestinatario::class, 'planilla_id');
    }
}
