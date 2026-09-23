<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IconBoxStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:255'],
            'icon_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Icon box title is required.',
            'icon_image.file' => 'The icon image must be a file.',
            'icon_image.mimes' => 'The icon image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'icon_image.max' => 'The icon image may not be greater than 4MB.',
        ];
    }
}
