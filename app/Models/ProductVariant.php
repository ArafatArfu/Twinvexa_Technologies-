<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price',
        'old_price',
        'quantity',
        'attribute_name',
        'attribute_value',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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
}