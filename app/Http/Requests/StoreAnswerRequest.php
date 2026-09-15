<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAnswerRequest extends FormRequest
{
    /**
     * @var list<string>
     */
    private const SCALE = ['always', 'often', 'sometimes', 'rarely', 'never'];

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        return [
            'answers' => ['nullable', 'array'],
            'answers.*' => ['required', Rule::in(self::SCALE)],
            'comment' => ['nullable', 'string', 'max:5000'],
            'boosters' => ['nullable', 'array', 'max:3'],
            'boosters.*' => ['integer', 'exists:quotas,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'answers.*.in' => 'One of the answers is not one of the offered options.',
            'boosters.max' => 'You may pick three boosters at most.',
            'boosters.*.exists' => 'One of the selected boosters no longer exists.',
        ];
    }
}
