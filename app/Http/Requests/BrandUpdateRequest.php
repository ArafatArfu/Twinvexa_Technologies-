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
            'banner_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Brand name is required.',
            'logo.file' => 'The brand logo must be a file.',
            'logo.mimes' => 'The brand logo must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'logo.max' => 'The brand logo may not be greater than 4MB.',
            'banner_image.file' => 'The brand banner image must be a file.',
            'banner_image.mimes' => 'The brand banner image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'banner_image.max' => 'The brand banner image may not be greater than 4MB.',
            'slug.unique' => 'This slug is already used. Please choose a different one.',
            'website_url.url' => 'Please enter a valid URL.',
        ];
    }
}
