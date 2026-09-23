<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'short_description',
        'description',
        'image',
        'banner',
        'icon',
        'order',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return str_starts_with($this->image, 'assets/')
            ? asset($this->image)
            : (Storage::disk('public')->exists($this->image) ? asset('storage/' . $this->image) : null);
    }

    public function getBannerUrlAttribute(): ?string
    {
        if (!$this->banner) {
            return null;
        }

        return str_starts_with($this->banner, 'assets/')
            ? asset($this->banner)
            : (Storage::disk('public')->exists($this->banner) ? asset('storage/' . $this->banner) : null);
    }

    public function getIconUrlAttribute(): ?string
    {
        if (!$this->icon) {
            return null;
        }

        return str_starts_with($this->icon, 'assets/')
            ? asset($this->icon)
            : (Storage::disk('public')->exists($this->icon) ? asset('storage/' . $this->icon) : null);
    }

    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }
}
