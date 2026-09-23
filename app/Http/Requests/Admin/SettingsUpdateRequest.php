<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_description' => ['nullable', 'string', 'max:1000'],
            'site_logo' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],

            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_keywords' => ['nullable', 'string', 'max:500'],

            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:500'],

            'footer_copyright' => ['nullable', 'string', 'max:255'],
            'footer_description' => ['nullable', 'string', 'max:1000'],
            'newsletter_text' => ['nullable', 'string', 'max:1000'],

            'new_arrivals_title' => ['nullable', 'string', 'max:255'],
            'trending_title' => ['nullable', 'string', 'max:255'],
            'deals_title' => ['nullable', 'string', 'max:255'],
            'recommendations_title' => ['nullable', 'string', 'max:255'],
            'categories_title' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'site_logo.file' => 'The site logo must be a file.',
            'site_logo.mimes' => 'The site logo must be an image file.',
            'site_logo.max' => 'The site logo may not be greater than 4MB.',
            'contact_email.email' => 'Please enter a valid email address.',
        ];
    }
}
