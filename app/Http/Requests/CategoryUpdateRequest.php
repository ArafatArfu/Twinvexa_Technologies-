<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->category?->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $categoryId],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'banner' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:8192'],
            'icon' => ['nullable', 'file', 'mimes:png,svg', 'max:1024'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.file' => 'The category image must be a file.',
            'image.mimes' => 'The category image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'image.max' => 'The category image may not be greater than 4MB.',
            'banner.file' => 'The category banner must be a file.',
            'banner.mimes' => 'The category banner must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'banner.max' => 'The category banner may not be greater than 8MB.',
            'icon.file' => 'The category icon must be a file.',
            'icon.mimes' => 'The category icon must be a file of type: png, svg.',
            'icon.max' => 'The category icon may not be greater than 1MB.',
            'slug.unique' => 'This slug is already used. Please choose a different one.',
        ];
    }
}
