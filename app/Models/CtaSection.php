<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtaSection extends Model
{
    protected $fillable = [
        'top_text',
        'heading',
        'description',
        'price',
        'old_price',
        'discount_text',
        'button_text',
        'button_link',
        'product_image',
        'background_image',
        'background_color',
        'product_id',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderByDesc('created_at');
    }

    public function getProductImageUrlAttribute(): ?string
    {
        if (!$this->product_image) {
            return null;
        }

        return str_starts_with($this->product_image, 'assets/')
            ? asset($this->product_image)
            : (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->product_image) ? asset('storage/' . $this->product_image) : null);
    }

    public function getBackgroundImageUrlAttribute(): ?string
    {
        if (!$this->background_image) {
            return null;
        }

        return str_starts_with($this->background_image, 'assets/')
            ? asset($this->background_image)
            : (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->background_image) ? asset('storage/' . $this->background_image) : null);
    }

    public function getFormattedPriceAttribute(): ?string
    {
        return $this->price !== null ? '$' . number_format((float) $this->price, 2) : null;
    }

    public function getFormattedOldPriceAttribute(): ?string
    {
        return $this->old_price !== null ? '$' . number_format((float) $this->old_price, 2) : null;
    }

    public function getDiscountPercentageAttribute(): ?string
    {
        if ($this->old_price && $this->price && $this->old_price > 0) {
            $old = (float) $this->old_price;
            $new = (float) $this->price;
            return round((($old - $new) / $old) * 100) . '%';
        }
        return null;
    }

    public function getProductUrlAttribute(): ?string
    {
        if ($this->product && $this->product->slug) {
            return route('cta-products.show', $this->product->slug);
        }

        return '#';
    }
}
