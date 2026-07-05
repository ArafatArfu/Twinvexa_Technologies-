<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;

class NewArrivalCategoryDemoSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Samsung 65" Class OLED 4K Smart TV',
                'category_id' => 5,
                'brand_id' => 1,
                'price' => 899.99,
                'old_price' => 1199.99,
                'quantity' => 12,
                'short_description' => 'Immersive OLED 4K Smart TV with infinite contrast, vivid colors, and smart streaming built-in.',
                'description' => '<p>Experience perfect blacks and incredible contrast with the Samsung 65" OLED 4K Smart TV. The OLED panel produces self-emissive pixels for infinite contrast, while the Neural Quantum Processor optimizes every scene. Smart TV features give you instant access to all your favorite streaming apps.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days.',
                'return_policy' => '30-day return policy for all unused items in original packaging.',
                'image' => 'assets/images/demos/demo-4/products/product-8.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-8.jpg',
                    'assets/images/demos/demo-4/products/product-5.jpg',
                ],
                'specifications' => [
                    ['key' => 'Screen Size', 'value' => '65 inches'],
                    ['key' => 'Panel', 'value' => 'OLED'],
                    ['key' => 'Resolution', 'value' => '4K UHD (3840 x 2160)'],
                    ['key' => 'Smart Platform', 'value' => 'Tizen OS'],
                ],
                'sku' => 'SAM-65OLED',
                'is_active' => true,
                'is_new' => true,
                'is_sale' => true,
                'is_new_arrival' => true,
                'display_order' => 10,
            ],
            [
                'name' => 'Apple MacBook Air 13-inch, 256GB SSD',
                'category_id' => 2,
                'brand_id' => 1,
                'price' => 999.99,
                'old_price' => 1099.99,
                'quantity' => 18,
                'short_description' => 'Incredibly thin and light laptop with M2 chip, Retina display, and all-day battery.',
                'description' => '<p>The MacBook Air 13-inch with M2 chip is the most capable MacBook Air ever. It features a stunning Retina display, a fanless design for silent operation, and up to 18 hours of battery life. The Magic Keyboard and Force Touch trackpad provide a premium typing experience.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days.',
                'return_policy' => '30-day return policy for all unused items in original packaging.',
                'image' => 'assets/images/demos/demo-4/products/product-1.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-1.jpg',
                    'assets/images/demos/demo-4/products/product-2.jpg',
                ],
                'specifications' => [
                    ['key' => 'Screen Size', 'value' => '13.6 inches'],
                    ['key' => 'Processor', 'value' => 'Apple M2'],
                    ['key' => 'Storage', 'value' => '256GB SSD'],
                    ['key' => 'Weight', 'value' => '1.24 kg'],
                ],
                'sku' => 'MBAIR-M2-256',
                'is_active' => true,
                'is_new' => true,
                'is_sale' => false,
                'is_new_arrival' => true,
                'display_order' => 20,
            ],
            [
                'name' => 'Apple Watch Series 8 45mm',
                'category_id' => 7,
                'brand_id' => 1,
                'price' => 399.99,
                'old_price' => 449.99,
                'quantity' => 25,
                'short_description' => 'Advanced smartwatch with health sensors, always-on Retina display, and crash detection.',
                'description' => '<p>The Apple Watch Series 8 features an always-on Retina display, advanced health sensors including blood oxygen and ECG, and innovative safety features like crash detection. It is swim-proof, has a fast charge battery, and works seamlessly with your iPhone.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days.',
                'return_policy' => '30-day return policy for all unused items in original packaging.',
                'image' => 'assets/images/demos/demo-4/products/product-12.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-12.jpg',
                    'assets/images/demos/demo-4/products/product-12-2.jpg',
                ],
                'specifications' => [
                    ['key' => 'Case Size', 'value' => '45mm'],
                    ['key' => 'Display', 'value' => 'Always-on Retina LTPO OLED'],
                    ['key' => 'Water Resistance', 'value' => '50 meters'],
                    ['key' => 'Battery', 'value' => 'Up to 18 hours'],
                ],
                'sku' => 'AW-S8-45MM',
                'is_active' => true,
                'is_new' => true,
                'is_sale' => true,
                'is_new_arrival' => true,
                'display_order' => 30,
            ],
            [
                'name' => 'Sony WH-1000XM5 Wireless Headphones',
                'category_id' => 6,
                'brand_id' => 1,
                'price' => 329.99,
                'old_price' => 399.99,
                'quantity' => 35,
                'short_description' => 'Industry-leading noise canceling wireless headphones with crystal clear audio.',
                'description' => '<p>The Sony WH-1000XM5 headphones deliver industry-leading noise canceling with two processors controlling 8 microphones. The result is almost no sound leakage and the best noise cancellation on the market. Crystal clear hands-free calling and up to 30 hours of battery life.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days.',
                'return_policy' => '30-day return policy for all unused items in original packaging.',
                'image' => 'assets/images/demos/demo-4/products/product-7.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-7.jpg',
                    'assets/images/demos/demo-4/products/product-6.jpg',
                ],
                'specifications' => [
                    ['key' => 'Type', 'value' => 'Over-ear'],
                    ['key' => 'Connectivity', 'value' => 'Bluetooth 5.2 / NFC'],
                    ['key' => 'Battery Life', 'value' => 'Up to 30 hours'],
                    ['key' => 'Noise Canceling', 'value' => 'Active / Adaptive'],
                ],
                'sku' => 'SONY-WH1000XM5',
                'is_active' => true,
                'is_new' => true,
                'is_sale' => true,
                'is_new_arrival' => true,
                'display_order' => 40,
            ],
            [
                'name' => 'Apple iPad Air 10.9-inch, 64GB',
                'category_id' => 1,
                'brand_id' => 1,
                'price' => 599.99,
                'old_price' => 649.99,
                'quantity' => 30,
                'short_description' => 'Incredible iPad Air with M1 chip, 10.9-inch Liquid Retina display, and all-day battery.',
                'description' => '<p>The iPad Air with the M1 chip takes performance to a whole new level. The 10.9-inch Liquid Retina display brings everything to life with true-to-life colors. Touch ID, Apple Pencil support, and Magic Keyboard compatibility make it the perfect tool for work and play.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days.',
                'return_policy' => '30-day return policy for all unused items in original packaging.',
                'image' => 'assets/images/demos/demo-4/products/product-11.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-11.jpg',
                    'assets/images/demos/demo-4/products/product-10.jpg',
                ],
                'specifications' => [
                    ['key' => 'Screen Size', 'value' => '10.9 inches'],
                    ['key' => 'Processor', 'value' => 'Apple M1'],
                    ['key' => 'Storage', 'value' => '64GB'],
                    ['key' => 'Weight', 'value' => '461g'],
                ],
                'sku' => 'IPAD-AIR-64',
                'is_active' => true,
                'is_new' => true,
                'is_sale' => false,
                'is_new_arrival' => true,
                'display_order' => 50,
            ],
            [
                'name' => 'Samsung Galaxy S23 Ultra 256GB',
                'category_id' => 4,
                'brand_id' => 1,
                'price' => 1099.99,
                'old_price' => 1199.99,
                'quantity' => 22,
                'short_description' => 'Ultimate Galaxy experience with 200MP camera, S Pen, and epic low-light photography.',
                'description' => '<p>The Galaxy S23 Ultra is the ultimate Galaxy experience. With a 200MP camera, Nightography, and the built-in S Pen, it is ready to help you create, connect, and conquer. The Snapdragon 8 Gen 2 processor delivers epic gaming and streaming performance.</p>',
                'shipping_information' => 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days.',
                'return_policy' => '30-day return policy for all unused items in original packaging.',
                'image' => 'assets/images/demos/demo-4/products/product-3.jpg',
                'gallery' => [
                    'assets/images/demos/demo-4/products/product-3.jpg',
                    'assets/images/demos/demo-4/products/product-4.jpg',
                ],
                'specifications' => [
                    ['key' => 'Display', 'value' => '6.8 inches Dynamic AMOLED 2X'],
                    ['key' => 'Storage', 'value' => '256GB'],
                    ['key' => 'Camera', 'value' => '200MP + 12MP + 10MP + 10MP'],
                    ['key' => 'Battery', 'value' => '5000 mAh'],
                ],
                'sku' => 'SAMS23ULTRA-256',
                'is_active' => true,
                'is_new' => true,
                'is_sale' => true,
                'is_new_arrival' => true,
                'display_order' => 60,
            ],
        ];

        foreach ($products as $index => $data) {
            $product = Product::create([
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
                'sku' => $data['sku'],
                'is_active' => $data['is_active'],
                'is_new' => $data['is_new'],
                'is_sale' => $data['is_sale'],
                'is_new_arrival' => $data['is_new_arrival'],
                'display_order' => $data['display_order'],
            ]);

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
