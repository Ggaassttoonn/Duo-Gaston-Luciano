<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
     
        $areaId = $this->route('area') ? $this->route('area')->id : null;

        return [
          
            'area' => 'sometimes|required|string|max:255|unique:areas,area,' . $areaId,
            'tipo' => 'sometimes|required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'area.required' => 'El nombre del área no puede quedar vacío.',
            'area.unique' => 'Ese nombre de área ya está en uso por otro registro.',
            'tipo.required' => 'El tipo de área no puede quedar vacío.',
        ];
    }
}