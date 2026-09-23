<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterSettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'background_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:8192'],
            'newsletter_title' => ['nullable', 'string', 'max:255'],
            'newsletter_subtitle' => ['nullable', 'string', 'max:500'],
            'email_placeholder' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'is_newsletter_active' => ['sometimes', 'boolean'],
            'footer_logo' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'footer_description' => ['nullable', 'string', 'max:1000'],
            'phone_support_text' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'support_icon' => ['nullable', 'string', 'max:255'],
            'copyright_text' => ['nullable', 'string', 'max:500'],
            'social_links' => ['nullable', 'array'],
            'payment_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'background_image.file' => 'The background image must be a file.',
            'background_image.mimes' => 'The background image must be jpeg, png, jpg, gif, or webp.',
            'background_image.max' => 'The background image may not be greater than 8MB.',
            'footer_logo.file' => 'The footer logo must be a file.',
            'footer_logo.mimes' => 'The footer logo must be jpeg, png, jpg, gif, webp, or svg.',
            'footer_logo.max' => 'The footer logo may not be greater than 4MB.',
            'payment_image.file' => 'The payment image must be a file.',
            'payment_image.mimes' => 'The payment image must be jpeg, png, jpg, gif, or webp.',
            'payment_image.max' => 'The payment image may not be greater than 4MB.',
        ];
    }
}
