<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->bannerProduct?->id;

        return [
            'banner_id' => ['sometimes', 'required', 'exists:banners,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:banner_products,slug,' . $productId],
            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'stock_status' => ['nullable', 'string', 'max:100'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'additional_information' => ['nullable', 'string'],
            'shipping_information' => ['nullable', 'string'],
            'return_policy' => ['nullable', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
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
            'banner_id.required' => 'Please select a banner.',
            'banner_id.exists' => 'Selected banner does not exist.',
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
