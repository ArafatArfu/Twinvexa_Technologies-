<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HeaderMenu extends Model
{
    protected $fillable = [
        'title',
        'url',
        'icon',
        'label',
        'label_class',
        'parent_id',
        'section_id',
        'order',
        'is_visible',
        'is_megamenu',
        'megamenu_class',
        'target',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_megamenu' => 'boolean',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(HeaderMenu::class, 'parent_id')->with('children')->orderBy('order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(HeaderMenu::class, 'parent_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(HeaderSection::class, 'section_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }
}