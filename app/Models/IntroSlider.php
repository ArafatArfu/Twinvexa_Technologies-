<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IntroSlider extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'short_content',
        'button_text',
        'button_url',
        'cta_text',
        'cta_url',
        'price',
        'old_price',
        'product_slug',
        'badge_text',
        'badge_type',
        'video_url',
        'image',
        'background_color',
        'text_color',
        'alignment',
        'overlay_opacity',
        'meta_title',
        'meta_description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function (IntroSlider $slider) {
            if (empty($slider->slug)) {
                $slider->slug = Str::slug($slider->title);
            }
        });

        static::updating(function (IntroSlider $slider) {
            if (empty($slider->slug)) {
                $slider->slug = Str::slug($slider->title);
            }
        });
    }

    public function sliderProduct()
    {
        return $this->hasOne(SliderProduct::class, 'intro_slider_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return str_starts_with($this->image, 'assets/')
            ? asset($this->image)
            : (Storage::disk('public')->exists($this->image) ? asset('storage/' . $this->image) : null);
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

    public function getLinkAttribute(): ?string
    {
        if ($this->sliderProduct && $this->sliderProduct->is_active) {
            return route('intro-slider.show', $this->slug);
        }

        if ($this->product_slug) {
            return route('products.show', $this->product_slug);
        }

        if ($this->button_url) {
            return $this->button_url;
        }

        return null;
    }
}
