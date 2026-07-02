<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntroSliderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:500'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'string', 'max:255'],
            'old_price' => ['nullable', 'string', 'max:255'],
            'badge_text' => ['nullable', 'string', 'max:255'],
            'badge_type' => ['nullable', 'string', 'in:sale,new,top'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'background_color' => ['nullable', 'string', 'max:255'],
            'text_color' => ['nullable', 'string', 'max:255'],
            'alignment' => ['nullable', 'string', 'in:left,center,right'],
            'overlay_opacity' => ['nullable', 'integer', 'min:0', 'max:90'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.file' => 'The image must be a file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'image.max' => 'The image may not be greater than 4MB.',
        ];
    }
}
