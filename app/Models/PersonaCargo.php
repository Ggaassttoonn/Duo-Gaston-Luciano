<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonaCargo extends Model
{
    protected $table = 'persona_cargos';

    protected $fillable = [
        'persona_id',
        'cargo_id',
        'sit_revista_id',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function sitRevista(): BelongsTo
    {
        return $this->belongsTo(SitRevista::class, 'sit_revista_id');
    }

    public function personaCargoCursados(): HasMany
    {
        return $this->hasMany(PersonaCargoCursado::class, 'persona_cargos_id');
    }
}
