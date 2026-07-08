<?php

namespace App\Http\Requests\EstadoDiaria;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoDiariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Habilitamos la validación para el endpoint
    }

    public function rules(): array
    {
        return [
            'estado'                  => 'required|string|max:100',
            'fecha'                   => 'required|date',
            'planificacion_diaria_id' => 'required|exists:planificaciones_diarias,id', // Asegurarte de que este sea el nombre de tu tabla
        ];
    }
}