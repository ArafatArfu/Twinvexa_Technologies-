<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->product?->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $productId],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'sku' => ['nullable', 'string', 'max:100'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['sometimes', 'required', 'integer', 'min:0'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'is_active' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_new' => ['sometimes', 'boolean'],
            'is_sale' => ['sometimes', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'price.required' => 'Product price is required.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'image.file' => 'The product image must be a file.',
            'image.mimes' => 'The product image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'image.max' => 'The product image may not be greater than 4MB.',
            'gallery.*.file' => 'Each gallery image must be a file.',
            'gallery.*.mimes' => 'Each gallery image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'gallery.*.max' => 'Each gallery image may not be greater than 4MB.',
            'slug.unique' => 'This slug is already used. Please choose a different one.',
        ];
    }
}
