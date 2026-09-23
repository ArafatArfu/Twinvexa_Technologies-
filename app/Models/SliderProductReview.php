<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SliderProductReview extends Model
{
    protected $fillable = [
        'slider_product_id',
        'name',
        'email',
        'rating',
        'comment',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function sliderProduct(): BelongsTo
    {
        return $this->belongsTo(SliderProduct::class);
    }
}
