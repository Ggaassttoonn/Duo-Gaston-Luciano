<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoCalendario extends Model
{
    use HasFactory;

    protected $table = 'eventos_calendario';

    protected $fillable = [
        'titulo',
        'tipo',
        'fecha',
        'hora',
        'descripcion',
        'autor_nombre',
        'autor_rol',
        'persona_id',
    ];

    protected $casts = [
        'fecha' => 'date:Y-m-d',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
