<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SliderProductVariant extends Model
{
    protected $fillable = [
        'slider_product_id',
        'name',
        'sku',
        'price',
        'old_price',
        'quantity',
        'attribute_name',
        'attribute_value',
    ];

    public function sliderProduct(): BelongsTo
    {
        return $this->belongsTo(SliderProduct::class);
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
}
