<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'ciclo'   => 'required|string|max:50',  
            'grado'   => 'required|string|max:50',   
            'seccion' => 'required|string|max:10',  
            'turno'   => 'required|string|max:30',   
        ];
    }
}