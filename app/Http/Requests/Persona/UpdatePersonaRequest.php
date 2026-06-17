<?php

namespace App\Http\Requests\Persona;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaRequest extends FormRequest
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
        // 
        $personaId = $this->route('persona') ? $this->route('persona')->id : null;

        return [
            'apellidos'        => 'sometimes|required|string|max:255',
            'nombres'          => 'sometimes|required|string|max:255',
            'dni'              => 'sometimes|required|integer|unique:personas,dni,' . $personaId,
            'e-mail'           => 'sometimes|required|email|max:255|unique:personas,e-mail,' . $personaId,
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
            'dni.unique'    => 'El DNI ingresado ya pertenece a otra persona.',
            'e-mail.unique' => 'El correo electrónico ya pertenece a otra persona.',
        ];
    }
}