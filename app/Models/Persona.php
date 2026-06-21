<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Persona extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'apellidos',
        'nombres',
        'dni',
        'email',
        'telefono',
        'direccion',
        'fecha_nacimiento',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function cargos(): HasMany
    {
        return $this->hasMany(PersonaCargo::class, 'personas_id');
    }
}
