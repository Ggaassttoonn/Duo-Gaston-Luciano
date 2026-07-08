<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $fillable = [
        'ciclo',
        'grado',
        'seccion',
        'turno',
    ];

    public function cursados(): HasMany
    {
        return $this->hasMany(Cursado::class, 'curso_id');
    }
}
