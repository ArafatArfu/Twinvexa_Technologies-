<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\IntroSlider;
use App\Models\SliderProduct;
use App\Models\SliderProductImage;
use App\Models\SliderProductSpecification;
use App\Models\SliderProductTag;
use App\Models\SliderProductVariant;
use Illuminate\Database\Seeder;

class IntroSliderSeeder extends Seeder
{
    public function run(): void
    {
        $tablets = Category::firstOrCreate(
            ['slug' => 'tablets'],
            ['name' => 'Tablets', 'is_active' => true]
        );

        $apple = Brand::firstOrCreate(
            ['slug' => 'apple'],
            ['name' => 'Apple', 'is_active' => true]
        );

        $slider1 = IntroSlider::updateOrCreate(
            ['slug' => 'beats-by-dre-studio-3'],
            [
                'title' => "beats by\nDre Studio 3",
                'subtitle' => 'Deals and Promotions',
                'price' => '$279.99',
                'old_price' => '$349.95',
                'badge_text' => 'Sale',
                'badge_type' => 'sale',
                'button_text' => 'Shop More',
                'button_url' => '#',
                'image' => 'assets/images/demos/demo-4/slider/slide-1.png',
                'order' => 1,
                'is_active' => true,
            ]
        );

        $product1 = SliderProduct::updateOrCreate(
            ['intro_slider_id' => $slider1->id],
            [
                'name' => 'beats by Dre Studio 3 Wireless Headphones',
                'category_id' => $tablets->id,
                'brand_id' => $apple->id,
                'sku' => 'BEATS-STUDIO-3',
                'price' => '279.99',
                'old_price' => '349.95',
                'quantity' => 20,
                'short_description' => 'Premium wireless headphones with active noise cancelling and up to 22 hours of battery life.',
                'description' => '<p>Experience studio-quality sound with beats by Dre Studio 3. Featuring active noise cancelling, pure adaptive noise cancelling, and a sleek over-ear design.</p><p>With up to 22 hours of battery life, you can enjoy your music all day long. The memory foam ear cups provide exceptional comfort for extended listening sessions.</p>',
                'is_active' => true,
            ]
        );

        if ($product1->images->isEmpty()) {
            SliderProductImage::create([
                'slider_product_id' => $product1->id,
                'image' => 'assets/images/demos/demo-4/products/single/headphones-1.jpg',
                'order' => 0,
            ]);
        }

        SliderProductSpecification::updateOrCreate(
            ['slider_product_id' => $product1->id, 'key' => 'Brand'],
            ['value' => 'Beats by Dre', 'order' => 1]
        );

        SliderProductTag::updateOrCreate(
            ['slider_product_id' => $product1->id, 'tag' => 'headphones']
        );

        $slider2 = IntroSlider::updateOrCreate(
            ['slug' => 'apple-ipad-pro-12-9-inch-64gb'],
            [
                'title' => "Apple iPad Pro\n12.9 Inch, 64GB",
                'subtitle' => 'New Arrival',
                'price' => '$999.99',
                'old_price' => null,
                'badge_text' => 'New',
                'badge_type' => 'new',
                'button_text' => 'Shop More',
                'button_url' => '#',
                'image' => 'assets/images/demos/demo-4/slider/slide-2.png',
                'order' => 2,
                'is_active' => true,
            ]
        );

        $product2 = SliderProduct::updateOrCreate(
            ['intro_slider_id' => $slider2->id],
            [
                'name' => 'Apple iPad Pro 12.9 Inch, 64GB',
                'category_id' => $tablets->id,
                'brand_id' => $apple->id,
                'sku' => 'IPAD-PRO-12-64',
                'price' => '999.99',
                'old_price' => null,
                'quantity' => 15,
                'short_description' => 'Apple iPad Pro 12.9-inch with M2 chip, Liquid Retina XDR display, 64GB storage, and all-day battery life.',
                'description' => '<p>The Apple iPad Pro 12.9-inch features a stunning Liquid Retina XDR display with ProMotion technology, making it the ultimate device for creativity and productivity. Powered by the M2 chip, it delivers exceptional performance for demanding tasks.</p><p>Featuring a 12-megapixel Wide camera and 10-megapixel Ultra Wide camera with LiDAR Scanner, the iPad Pro captures stunning photos and videos.</p>',
                'is_active' => true,
            ]
        );

        if ($product2->images->isEmpty()) {
            SliderProductImage::create([
                'slider_product_id' => $product2->id,
                'image' => 'assets/images/demos/demo-4/products/single/ipad-pro-1.jpg',
                'order' => 0,
            ]);
            SliderProductImage::create([
                'slider_product_id' => $product2->id,
                'image' => 'assets/images/demos/demo-4/products/single/ipad-pro-2.jpg',
                'order' => 1,
            ]);
            SliderProductImage::create([
                'slider_product_id' => $product2->id,
                'image' => 'assets/images/demos/demo-4/products/single/ipad-pro-3.jpg',
                'order' => 2,
            ]);
        }

        SliderProductVariant::updateOrCreate(
            ['slider_product_id' => $product2->id, 'name' => '128GB / Silver'],
            [
                'sku' => 'IPAD-PRO-12-128-SL',
                'price' => '1099.99',
                'old_price' => null,
                'quantity' => 10,
                'attribute_name' => 'Configuration',
                'attribute_value' => '128GB / Silver',
            ]
        );

        SliderProductSpecification::updateOrCreate(
            ['slider_product_id' => $product2->id, 'key' => 'Brand'],
            ['value' => 'Apple', 'order' => 1]
        );
        SliderProductSpecification::updateOrCreate(
            ['slider_product_id' => $product2->id, 'key' => 'Display'],
            ['value' => '12.9-inch Liquid Retina XDR display', 'order' => 2]
        );
        SliderProductSpecification::updateOrCreate(
            ['slider_product_id' => $product2->id, 'key' => 'Processor'],
            ['value' => 'Apple M2 chip', 'order' => 3]
        );
        SliderProductSpecification::updateOrCreate(
            ['slider_product_id' => $product2->id, 'key' => 'Storage'],
            ['value' => '64GB', 'order' => 4]
        );

        SliderProductTag::updateOrCreate(
            ['slider_product_id' => $product2->id, 'tag' => 'tablet']
        );
        SliderProductTag::updateOrCreate(
            ['slider_product_id' => $product2->id, 'tag' => 'apple']
        );
    }
}
