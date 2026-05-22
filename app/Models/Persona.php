<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Persona extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'apellidos',
        'nombres',
        'dni',
        'e-mail',
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
