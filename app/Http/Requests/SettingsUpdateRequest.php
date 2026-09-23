<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach (array_keys($this->except(['_token', '_method'])) as $field) {
            $rules[$field] = ['nullable'];
        }

        return $rules;
    }
}
