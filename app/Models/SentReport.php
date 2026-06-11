<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SentReport extends Model
{
    protected $fillable = [
        'director_id', 'planilla_id', 'docente_id',
        'comentario', 'audio_base64', 'audio_mime',
    ];

    public function director(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'director_id');
    }

    public function planilla(): BelongsTo
    {
        return $this->belongsTo(Planilla::class);
    }

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'docente_id');
    }
}
