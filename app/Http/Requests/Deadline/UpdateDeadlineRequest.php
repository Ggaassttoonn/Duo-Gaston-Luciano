<?php

namespace App\Http\Requests\Deadline;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeadlineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'          => 'sometimes|required|string|max:255',
            'descripcion'     => 'nullable|string',
            'fecha_limite'    => 'sometimes|required|date',
            'user_ids'        => 'sometimes|required|array|min:1',
            'user_ids.*'      => 'required|exists:users,id',
        ];
    }
}
