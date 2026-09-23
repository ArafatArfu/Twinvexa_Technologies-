<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BannerProduct;
use Illuminate\Database\Seeder;

class BannerProductSeeder extends Seeder
{
    public function run(): void
    {
        $banner = Banner::first();

        if (!$banner) {
            return;
        }

        BannerProduct::updateOrCreate(
            ['slug' => 'samsung-galaxy-note9'],
            [
                'banner_id' => $banner->id,
                'name' => 'Samsung Galaxy Note9',
                'category' => 'Smart Phones',
                'brand' => 'Samsung',
                'sku' => 'SAM-NOTE9-64',
                'price' => 999.99,
                'old_price' => 1149.99,
                'stock_status' => 'In Stock',
                'quantity' => 15,
                'short_description' => 'Experience the power of the Samsung Galaxy Note9 with S Pen, 128GB storage, and a stunning 6.4-inch display.',
                'description' => '<p>The Samsung Galaxy Note9 features a 6.4-inch Super AMOLED display, powered by the Exynos 9810 processor. With 128GB of internal storage and expandable storage up to 512GB, you have all the space you need for your apps, photos, and videos.</p><p>The S Pen has been upgraded with Bluetooth functionality, allowing you to control your camera, presentations, and more with a click. The dual 12MP rear cameras capture stunning photos in any lighting condition.</p>',
                'additional_information' => '<p><strong>Display:</strong> 6.4-inch Super AMOLED</p><p><strong>Processor:</strong> Exynos 9810</p><p><strong>Storage:</strong> 128GB expandable up to 512GB</p>',
                'shipping_information' => '<p>Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.</p>',
                'return_policy' => '<p>We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.</p>',
                'seo_title' => 'Samsung Galaxy Note9 - Buy Online',
                'seo_description' => 'Buy Samsung Galaxy Note9 online at the best price. Experience the power of S Pen, 128GB storage, and stunning 6.4-inch display.',
                'display_order' => 1,
            ]
        );
    }
}
