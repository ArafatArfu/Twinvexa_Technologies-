<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'old_price',
        'image',
        'quantity',
        'is_active',
        'is_featured',
        'is_new',
        'is_sale',
        'is_new_arrival',
        'is_deal',
        'deal_label',
        'deal_start_date',
        'deal_end_date',
        'is_trending',
        'is_recommendation',
        'is_top_rated',
        'is_best_selling',
        'is_on_sale',
        'badge_type',
        'custom_badge_text',
        'category_id',
        'brand_id',
        'shipping_information',
        'return_policy',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_sale' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_deal' => 'boolean',
        'is_trending' => 'boolean',
        'is_recommendation' => 'boolean',
        'is_top_rated' => 'boolean',
        'is_best_selling' => 'boolean',
        'is_on_sale' => 'boolean',
        'deal_start_date' => 'date',
        'deal_end_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->name);
            }
        });
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
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(ProductTag::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeDeal($query)
    {
        return $query->where('is_deal', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeRecommendation($query)
    {
        return $query->where('is_recommendation', true);
    }

    public function scopeTopRated($query)
    {
        return $query->where('is_top_rated', true);
    }

    public function scopeBestSelling($query)
    {
        return $query->where('is_best_selling', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', true);
    }

    public function getDiscountPercentageAttribute(): ?string
    {
        if ($this->old_price && $this->price) {
            $old = (float) str_replace(['$', ','], '', $this->old_price);
            $new = (float) str_replace(['$', ','], '', $this->price);
            if ($old > 0) {
                $percentage = round((($old - $new) / $old) * 100);
                return $percentage . '%';
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

    public function getBadgeAttribute(): ?array
    {
        if ($this->badge_type === 'none' || !$this->badge_type) {
            return null;
        }

        $text = $this->custom_badge_text ?: ucfirst(str_replace('_', ' ', $this->badge_type));
        $type = $this->badge_type;

        if (in_array($type, ['trending', 'top_rated', 'best_selling', 'hot_deal'])) {
            $type = 'top';
        }

        return [
            'type' => $type,
            'text' => $text,
        ];
    }

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return str_starts_with($this->image, 'assets/')
            ? asset($this->image)
            : (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image) ? asset('storage/' . $this->image) : null);
    }
}