<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanillaRevision extends Model
{
    protected $fillable = [
        'planilla_id', 'director_id', 'estado',
        'comentario', 'audio_base64', 'audio_mime',
        'planilla_original_id',
    ];

    public function planilla(): BelongsTo
    {
        return $this->belongsTo(Planilla::class);
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'director_id');
    }
}
