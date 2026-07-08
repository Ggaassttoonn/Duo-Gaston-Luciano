<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'    => 'required|string|in:submitted,approved',
            'respuesta' => 'required_if:status,submitted|nullable|string',
        ];
    }
}
