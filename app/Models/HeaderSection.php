<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeaderSection extends Model
{
    protected $fillable = [
        'type',
        'key',
        'title',
        'content',
        'order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(HeaderMenu::class, 'section_id')->with('children')->orderBy('order');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}