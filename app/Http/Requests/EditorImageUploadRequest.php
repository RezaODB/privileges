<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditorImageUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (int) $this->user()?->role === 2;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'bail',
                'required',
                'file',
                'image',
                'mimetypes:image/jpeg,image/png,image/webp,image/gif',
                'extensions:jpg,jpeg,png,webp,gif',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.image' => 'The upload must be a valid image.',
            'file.mimetypes' => 'Only JPG, PNG, WEBP, and GIF images are allowed.',
            'file.extensions' => 'Only JPG, PNG, WEBP, and GIF images are allowed.',
            'file.max' => 'The image size may not exceed 5 MB.',
        ];
    }
}
