<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\Category;
use App\Models\Brand;

class DealProductsSeeder extends Seeder
{
    public function run(): void
    {
        $appleBrand = Brand::firstOrCreate(
            ['slug' => 'apple'],
            ['name' => 'Apple', 'is_active' => true]
        );

        $categories = [
            'computer-laptop' => Category::where('slug', 'computer-laptop')->firstOrFail()->id,
            'digital-cameras' => Category::where('slug', 'digital-cameras')->firstOrFail()->id,
            'smart-phones' => Category::where('slug', 'smart-phones')->firstOrFail()->id,
            'televisions' => Category::where('slug', 'televisions')->firstOrFail()->id,
            'audio' => Category::where('slug', 'audio')->firstOrFail()->id,
        ];

        $products = [
            [
                'name' => 'Deal: Apple iPad Pro 12.9 Inch, 64GB',
                'category_id' => $categories['computer-laptop'] ?? 1,
                'brand_id' => $appleBrand->id,
                'price' => 999.99,
                'old_price' => 1099.99,
                'quantity' => 25,
                'short_description' => 'Powerful and versatile tablet with Liquid Retina XDR display, M2 chip, and all-day battery life.',
                'description' => '<p>The iPad Pro 12.9-inch features a stunning Liquid Retina XDR display with ProMotion technology for smooth scrolling and responsive touch. Powered by the M2 chip, it delivers desktop-class performance in a thin and light design. Perfect for creative professionals, students, and anyone who needs the ultimate iPad experience.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.',
                'return_policy' => 'We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.',
                'image' => 'assets/images/demos/demo-4/products/product-10.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-10.jpg',
                    'assets/images/demos/demo-4/products/product-11.jpg',
                ],
                'specifications' => [
                    ['key' => 'Screen Size', 'value' => '12.9 inches'],
                    ['key' => 'Storage', 'value' => '64GB'],
                    ['key' => 'Processor', 'value' => 'Apple M2'],
                    ['key' => 'Weight', 'value' => '682g'],
                ],
                'sku' => 'DEAL-IPAD-001',
                'is_active' => true,
                'is_deal' => true,
                'deal_label' => "Today's Deal",
                'deal_start_date' => now()->subDays(3)->format('Y-m-d'),
                'deal_end_date' => now()->addDays(7)->format('Y-m-d'),
                'display_order' => 1,
            ],
            [
                'name' => 'Deal: Sony Alpha a5100 Mirrorless Camera',
                'category_id' => $categories['digital-cameras'] ?? 3,
                'brand_id' => $appleBrand->id,
                'price' => 549.99,
                'old_price' => 699.99,
                'quantity' => 15,
                'short_description' => 'Compact mirrorless camera with 24MP APS-C sensor, fast autofocus, and 4K video recording.',
                'description' => '<p>The Sony Alpha a5100 is a compact and lightweight mirrorless camera perfect for travel and everyday photography. It features a 24.2MP APS-C sensor, 179-point phase-detection autofocus system, and Full HD 60p video recording. The tilting LCD screen makes it easy to capture selfies and creative angles.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.',
                'return_policy' => 'We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.',
                'image' => 'assets/images/demos/demo-4/products/product-14.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-14.jpg',
                    'assets/images/demos/demo-4/products/product-13.jpg',
                ],
                'specifications' => [
                    ['key' => 'Sensor', 'value' => '24.2MP APS-C'],
                    ['key' => 'Video', 'value' => 'Full HD 60p'],
                    ['key' => 'Weight', 'value' => '283g'],
                    ['key' => 'Battery', 'value' => 'Up to 400 shots'],
                ],
                'sku' => 'DEAL-SONY-001',
                'is_active' => true,
                'is_deal' => true,
                'deal_label' => 'Hot Deal',
                'deal_start_date' => now()->subDays(1)->format('Y-m-d'),
                'deal_end_date' => now()->addDays(5)->format('Y-m-d'),
                'display_order' => 2,
            ],
            [
                'name' => 'Deal: Bose SoundSport Wireless Headphones',
                'category_id' => $categories['audio'] ?? 6,
                'brand_id' => $appleBrand->id,
                'price' => 129.99,
                'old_price' => 149.99,
                'quantity' => 40,
                'short_description' => 'Sport-optimized wireless earbuds with StayHear+ tips for secure, comfortable fit during any workout.',
                'description' => '<p>Bose SoundSport wireless headphones are designed for exercise enthusiasts. They feature sweat-resistant construction, StayHear+ tips for unparalleled comfort and stability, and Bluetooth connectivity for wireless freedom. The inline microphone and remote let you switch between calls and music seamlessly.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.',
                'return_policy' => 'We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.',
                'image' => 'assets/images/demos/demo-4/products/product-6.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-6.jpg',
                    'assets/images/demos/demo-4/products/product-7.jpg',
                ],
                'specifications' => [
                    ['key' => 'Type', 'value' => 'In-ear'],
                    ['key' => 'Connectivity', 'value' => 'Bluetooth'],
                    ['key' => 'Battery Life', 'value' => 'Up to 6 hours'],
                    ['key' => 'Sweat Resistant', 'value' => 'Yes'],
                ],
                'sku' => 'DEAL-BOSE-001',
                'is_active' => true,
                'is_deal' => true,
                'deal_label' => 'Outlet',
                'deal_start_date' => now()->subDays(5)->format('Y-m-d'),
                'deal_end_date' => now()->addDays(10)->format('Y-m-d'),
                'display_order' => 3,
            ],
            [
                'name' => 'Deal: Samsung 55" Class LED 2160p Smart TV',
                'category_id' => $categories['televisions'] ?? 5,
                'brand_id' => $appleBrand->id,
                'price' => 449.99,
                'old_price' => 599.99,
                'quantity' => 10,
                'short_description' => 'Crystal UHD 4K Smart TV with purColor, Micro Contrast, and smart streaming apps built-in.',
                'description' => '<p>Experience vivid, lifelike colors with the Samsung 55" Crystal UHD TV. The purColor technology makes every scene look vibrant and true-to-life, while the Micro Contrast enhances detail in both light and dark areas. Built-in smart apps give you instant access to your favorite streaming content without a separate device.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.',
                'return_policy' => 'We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.',
                'image' => 'assets/images/demos/demo-4/products/product-5.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-5.jpg',
                    'assets/images/demos/demo-4/products/product-9.jpg',
                ],
                'specifications' => [
                    ['key' => 'Screen Size', 'value' => '55 inches'],
                    ['key' => 'Resolution', 'value' => '4K UHD (3840 x 2160)'],
                    ['key' => 'Smart Platform', 'value' => 'Tizen OS'],
                    ['key' => 'HDMI Ports', 'value' => '3'],
                ],
                'sku' => 'DEAL-SAM-001',
                'is_active' => true,
                'is_deal' => true,
                'deal_label' => "Today's Deal",
                'deal_start_date' => now()->subDays(2)->format('Y-m-d'),
                'deal_end_date' => now()->addDays(4)->format('Y-m-d'),
                'display_order' => 4,
            ],
            [
                'name' => 'Deal: Google Pixel 3 XL 128GB',
                'category_id' => $categories['smart-phones'] ?? 4,
                'brand_id' => $appleBrand->id,
                'price' => 399.99,
                'old_price' => 499.99,
                'quantity' => 20,
                'short_description' => 'Premium Android smartphone with 6.3-inch display, 4GB RAM, 128GB storage, and exceptional camera.',
                'description' => '<p>The Google Pixel 3 XL delivers a pure Android experience with a stunning 6.3-inch QHD+ display. Its 12.2MP dual-pixel rear camera captures incredible photos in any light, while Night Sight mode lets you take bright, detailed pictures even in the dark. The all-day battery and Quick Charge keep you powered up.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.',
                'return_policy' => 'We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.',
                'image' => 'assets/images/demos/demo-4/products/product-4.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-4.jpg',
                    'assets/images/demos/demo-4/products/product-3.jpg',
                ],
                'specifications' => [
                    ['key' => 'Display', 'value' => '6.3 inches QHD+'],
                    ['key' => 'RAM', 'value' => '4GB'],
                    ['key' => 'Storage', 'value' => '128GB'],
                    ['key' => 'Camera', 'value' => '12.2MP Dual Pixel'],
                ],
                'sku' => 'DEAL-GOOG-001',
                'is_active' => true,
                'is_deal' => true,
                'deal_label' => 'Hot Deal',
                'deal_start_date' => now()->format('Y-m-d'),
                'deal_end_date' => now()->addDays(3)->format('Y-m-d'),
                'display_order' => 5,
            ],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'name' => $data['name'],
                    'slug' => null,
                    'category_id' => $data['category_id'],
                    'brand_id' => $data['brand_id'],
                    'price' => $data['price'],
                    'old_price' => $data['old_price'],
                    'quantity' => $data['quantity'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'shipping_information' => $data['shipping_information'],
                    'return_policy' => $data['return_policy'],
                    'image' => $data['image'],
                    'is_active' => $data['is_active'],
                    'is_deal' => $data['is_deal'],
                    'deal_label' => $data['deal_label'],
                    'deal_start_date' => $data['deal_start_date'],
                    'deal_end_date' => $data['deal_end_date'],
                    'display_order' => $data['display_order'],
                ]
            );

            $product->images()->delete();
            $product->specifications()->delete();

            foreach ($data['gallery'] as $galleryIndex => $galleryImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $galleryImage,
                    'order' => $galleryIndex + 1,
                ]);
            }

            foreach ($data['specifications'] as $specIndex => $spec) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'key' => $spec['key'],
                    'value' => $spec['value'],
                    'order' => $specIndex + 1,
                ]);
            }
        }
    }
}
