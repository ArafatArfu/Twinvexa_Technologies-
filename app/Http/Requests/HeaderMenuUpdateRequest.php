<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderMenuUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'label' => ['nullable', 'string', 'max:255'],
            'label_class' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:header_menus,id'],
            'section_id' => ['sometimes', 'required', 'exists:header_sections,id'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['sometimes', 'boolean'],
            'is_megamenu' => ['sometimes', 'boolean'],
            'megamenu_class' => ['nullable', 'string', 'max:255'],
            'target' => ['nullable', 'in:_self,_blank,_parent,_top'],
        ];
    }
}