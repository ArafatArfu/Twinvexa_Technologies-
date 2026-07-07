<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrendingBanner;
use App\Models\Product;

class TrendingBannerSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::where('is_trending', true)->first();

        if ($product) {
            TrendingBanner::updateOrCreate(
                ['id' => 1],
                [
                    'title' => 'Trending Products',
                    'subtitle' => 'Up to 50% off',
                    'highlight_text' => 'Limited time offer',
                    'button_text' => 'Shop Now',
                    'product_id' => $product->id,
                    'banner_image' => 'assets/images/demos/demo-4/banners/banner-4.jpg',
                    'background_color' => '#f5f5f5',
                    'text_color' => '#333333',
                    'is_active' => true,
                    'display_order' => 1,
                ]
            );
        }
    }
}
