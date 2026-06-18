<?php

namespace App\Http\Requests\Persona;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
    /**
     * 
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 
     */
    public function rules(): array
    {
        return [
            'apellidos'        => 'required|string|max:255',
            'nombres'          => 'required|string|max:255',
            'dni'              => 'required|integer|unique:personas,dni', 
            'email'           => 'required|email|max:255|unique:personas,email', 
            'telefono'         => 'nullable|string|max:50',
            'direccion'        => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today', 
        ];
    }

    /**
     * 
     */
    public function messages(): array
    {
        return [
            'dni.unique'     => 'El DNI ingresado ya se encuentra registrado.',
            'email.unique'  => 'El correo electrónico ya se encuentra registrado.',
            'email.email'   => 'El formato del correo electrónico no es válido.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser igual o posterior al día de hoy.',
        ];
    }
}