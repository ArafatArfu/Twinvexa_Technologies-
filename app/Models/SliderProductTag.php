<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SliderProductTag extends Model
{
    protected $fillable = [
        'slider_product_id',
        'tag',
    ];

    public function sliderProduct(): BelongsTo
    {
        return $this->belongsTo(SliderProduct::class);
    }
}
