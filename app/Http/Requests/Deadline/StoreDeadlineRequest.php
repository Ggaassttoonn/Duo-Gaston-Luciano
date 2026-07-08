<?php

namespace App\Http\Requests\Deadline;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeadlineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'fecha_limite'    => 'required|date|after:now',
            'user_ids'        => 'required|array|min:1',
            'user_ids.*'      => 'required|exists:users,id',
        ];
    }
}
