<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderSectionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255', 'unique:header_sections,key'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['sometimes', 'boolean'],
        ];
    }
}