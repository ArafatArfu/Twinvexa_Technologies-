<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavbarItem extends Model
{
    protected $fillable = [
        'title',
        'url',
        'icon',
        'label',
        'label_class',
        'parent_id',
        'order',
        'is_visible',
        'is_dropdown',
        'target',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_dropdown' => 'boolean',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(NavbarItem::class, 'parent_id')->orderBy('order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavbarItem::class, 'parent_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }

    public function scopeWithChildren($query)
    {
        return $query->parents()->with('children');
    }
}