<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BannerProduct extends Model
{
    protected $fillable = [
        'banner_id',
        'name',
        'slug',
        'category',
        'brand',
        'sku',
        'price',
        'old_price',
        'stock_status',
        'quantity',
        'short_description',
        'description',
        'image',
        'seo_title',
        'seo_description',
        'additional_information',
        'shipping_information',
        'return_policy',
        'display_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
    ];

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BannerProductImage::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(BannerProductSpecification::class);
    }
}
