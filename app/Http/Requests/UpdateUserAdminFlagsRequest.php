<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAdminFlagsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (int) $this->user()?->role === 2;
    }

    public function rules(): array
    {
        return [
            'important' => ['required', 'boolean'],
            'shot' => ['required', 'boolean'],
            'questionnaire' => ['required', 'boolean'],
            'interviewed' => ['required', 'boolean'],
            'eject' => ['required', 'boolean'],
        ];
    }
}
