<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'banner_image',
        'short_description',
        'description',
        'website_url',
        'is_active',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }
}