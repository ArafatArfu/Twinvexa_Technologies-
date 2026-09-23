<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CtaSectionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'top_text' => ['nullable', 'string', 'max:255'],
            'heading' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'discount_text' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'url', 'max:500'],
            'product_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'background_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'background_color' => ['nullable', 'string', 'max:50'],
            'product_id' => ['nullable', 'exists:products,id'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_image.file' => 'The product image must be a file.',
            'product_image.mimes' => 'The product image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'product_image.max' => 'The product image may not be greater than 4MB.',
            'background_image.file' => 'The background image must be a file.',
            'background_image.mimes' => 'The background image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'background_image.max' => 'The background image may not be greater than 4MB.',
            'button_link.url' => 'The button link must be a valid URL.',
            'product_id.exists' => 'Selected product does not exist.',
        ];
    }
}
