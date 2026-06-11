<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanillaDestinatario extends Model
{
    protected $table = 'planilla_destinatarios';

    protected $fillable = [
        'planilla_id',
        'director_id',
        'comentario',
        'audio',
        'leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    public function planilla(): BelongsTo
    {
        return $this->belongsTo(Planilla::class, 'planilla_id');
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'director_id');
    }
}
