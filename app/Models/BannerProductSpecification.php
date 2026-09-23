<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannerProductSpecification extends Model
{
    protected $fillable = [
        'banner_product_id',
        'key',
        'value',
        'order',
    ];

    public function bannerProduct(): BelongsTo
    {
        return $this->belongsTo(BannerProduct::class);
    }
}
