<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'sku' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'old_price' => ['nullable', 'string', 'max:255'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'main_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'main_image.file' => 'The main image must be a file.',
            'main_image.mimes' => 'The main image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'main_image.max' => 'The main image may not be greater than 4MB.',
            'gallery_images.*.file' => 'Each gallery image must be a file.',
            'gallery_images.*.mimes' => 'Each gallery image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'gallery_images.*.max' => 'Each gallery image may not be greater than 4MB.',
        ];
    }
}
