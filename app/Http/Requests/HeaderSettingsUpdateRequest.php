<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderSettingsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:2048'], // 2MB max, allows SVG
            'logo_width' => ['nullable', 'integer', 'min:10', 'max:1000'],
            'logo_height' => ['nullable', 'integer', 'min:10', 'max:500'],
            'logo_text' => ['nullable', 'string', 'max:255'],
            'sticky_class' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'contact_icon' => ['nullable', 'string', 'max:50'],
            'top_bar_text' => ['nullable', 'string', 'max:255'],
            'top_bar_highlight' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.file' => 'The logo must be a file.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'logo.max' => 'The logo may not be greater than 2MB.',
        ];
    }
}