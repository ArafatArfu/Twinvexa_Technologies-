<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SliderProduct extends Model
{
    protected $fillable = [
        'intro_slider_id',
        'name',
        'category_id',
        'brand_id',
        'sku',
        'price',
        'old_price',
        'quantity',
        'short_description',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quantity' => 'integer',
    ];

    public function slider(): BelongsTo
    {
        return $this->belongsTo(IntroSlider::class, 'intro_slider_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(SliderProductImage::class)->orderBy('order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(SliderProductVariant::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(SliderProductSpecification::class)->orderBy('order');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(SliderProductTag::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(SliderProductReview::class);
    }

    public function getDiscountPercentageAttribute(): ?string
    {
        if ($this->old_price && $this->price) {
            $old = (float) str_replace(['$', ','], '', $this->old_price);
            $new = (float) str_replace(['$', ','], '', $this->price);
            if ($old > 0) {
                return round((($old - $new) / $old) * 100) . '%';
            }
        }

        return null;
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }
}
