<?php

namespace Database\Seeders;

use App\Models\IntroSlider;
use Illuminate\Database\Seeder;

class IntroSliderSeeder extends Seeder
{
    public function run(): void
    {
        IntroSlider::insert([
            [
                'title' => 'beats by<br>Dre Studio 3',
                'subtitle' => 'Deals and Promotions',
                'description' => null,
                'button_text' => 'Shop More',
                'button_url' => '#',
                'price' => '$279.99',
                'old_price' => '$349.95',
                'product_slug' => 'beats-studio-3',
                'image' => 'assets/images/demos/demo-4/slider/slide-1.png',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Apple iPad Pro<br>12.9 Inch, 64GB',
                'subtitle' => 'New Arrival',
                'description' => null,
                'button_text' => 'Shop More',
                'button_url' => '#',
                'price' => '$999.99',
                'old_price' => null,
                'product_slug' => 'apple-ipad-pro',
                'image' => 'assets/images/demos/demo-4/slider/slide-2.png',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}