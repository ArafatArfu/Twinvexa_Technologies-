<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterLinkUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'column_type' => ['required', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:500'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Link title is required.',
            'column_type.required' => 'Please select a column.',
        ];
    }
}
