<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanillaState extends Model
{
    protected $fillable = ['planilla_id', 'user_id', 'estado'];

    public function planilla(): BelongsTo
    {
        return $this->belongsTo(Planilla::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
}
