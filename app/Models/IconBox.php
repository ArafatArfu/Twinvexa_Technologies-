<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IconBox extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'icon_class',
        'icon_image',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }
}
