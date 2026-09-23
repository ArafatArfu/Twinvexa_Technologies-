<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'highlight_text',
        'button_text',
        'button_link',
        'image',
        'background_color',
        'text_color',
        'seo_title',
        'seo_description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(BannerProduct::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
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
}
