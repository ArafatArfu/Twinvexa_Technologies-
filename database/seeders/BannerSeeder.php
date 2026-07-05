<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banner = Banner::create([
            'title' => 'Save $150 <strong>on Samsung <br>Galaxy Note9</strong>',
            'subtitle' => 'Smart Offer',
            'button_text' => 'Shop Now',
            'button_link' => '/banner-product/samsung-galaxy-note9',
            'background_color' => '#f5f6f9',
            'text_color' => '#333333',
            'order' => 1,
            'is_active' => true,
        ]);
    }
}
