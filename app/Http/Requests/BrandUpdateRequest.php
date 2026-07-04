<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brandId = $this->brand?->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:brands,slug,' . $brandId],
            'logo' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Brand name is required.',
            'logo.file' => 'The brand logo must be a file.',
            'logo.mimes' => 'The brand logo must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'logo.max' => 'The brand logo may not be greater than 4MB.',
            'slug.unique' => 'This slug is already used. Please choose a different one.',
        ];
    }
}
