<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SliderProductImage extends Model
{
    protected $fillable = [
        'slider_product_id',
        'image',
        'order',
    ];

    public function sliderProduct(): BelongsTo
    {
        return $this->belongsTo(SliderProduct::class);
    }
}
