<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;

class RecommendationProductsSeeder extends Seeder
{
    private function category(string $name): ?int
    {
        $category = Category::firstOrCreate(
            ['name' => $name],
            ['slug' => \Illuminate\Support\Str::slug($name), 'is_active' => true, 'order' => 0]
        );

        return $category->id;
    }

    private function brand(string $name): ?int
    {
        $brand = Brand::firstOrCreate(
            ['name' => $name],
            ['slug' => \Illuminate\Support\Str::slug($name), 'is_active' => true]
        );

        return $brand->id;
    }

    public function run(): void
    {
        $shipping = 'Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.';
        $returns = 'We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.';

        $products = [
            [
                'name' => 'Beats by Dr. Dre Wireless Headphones',
                'category' => 'Headphones',
                'brand' => 'Beats',
                'price' => 279.99,
                'old_price' => 349.99,
                'quantity' => 30,
                'short_description' => 'Premium wireless headphones with deep bass and up to 22 hours of battery life.',
                'description' => '<p>Experience immersive sound with the Beats Wireless Headphones. Featuring premium playback, fine-tuned acoustics, and a comfortable on-ear design, these headphones are perfect for everyday listening.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-10.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-10.jpg', 'assets/images/demos/demo-4/products/product-11.jpg'],
                'sku' => 'BEATS-WL-01',
                'badge_type' => 'sale',
                'custom_badge_text' => 'Sale',
                'display_order' => 1,
            ],
            [
                'name' => 'GoPro HERO7 Black HD Waterproof Action',
                'category' => 'Cameras & Camcorders',
                'brand' => 'GoPro',
                'price' => 349.99,
                'old_price' => null,
                'quantity' => 18,
                'short_description' => 'Rugged waterproof action camera with 4K video and HyperSmooth stabilization.',
                'description' => '<p>Capture your adventures with the GoPro HERO7 Black. Shoot stunning 4K video with HyperSmooth stabilization and share your story anywhere.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-11.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-11.jpg'],
                'sku' => 'GOPRO-H7-01',
                'badge_type' => 'top',
                'custom_badge_text' => 'Top',
                'display_order' => 2,
            ],
            [
                'name' => 'Apple Watch Series 3 with White Sport Band',
                'category' => 'Smartwatches',
                'brand' => 'Apple',
                'price' => 214.49,
                'old_price' => null,
                'quantity' => 22,
                'short_description' => 'Stay connected with the Apple Watch Series 3 featuring fitness tracking and notifications.',
                'description' => '<p>The Apple Watch Series 3 helps you live a healthier, more active life. Track workouts, monitor your heart rate, and stay connected on the go.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-12.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-12.jpg', 'assets/images/demos/demo-4/products/product-12-2.jpg'],
                'sku' => 'APPLE-WS3-01',
                'badge_type' => 'new',
                'custom_badge_text' => 'New',
                'display_order' => 3,
            ],
            [
                'name' => 'Lenovo 330-15IKBR 15.6" Laptop',
                'category' => 'Laptops',
                'brand' => 'Lenovo',
                'price' => 339.99,
                'old_price' => null,
                'quantity' => 0,
                'short_description' => 'Reliable everyday laptop with a 15.6" display, ideal for work and study.',
                'description' => '<p>The Lenovo 330-15IKBR delivers dependable performance for daily computing tasks, with a crisp 15.6-inch display and a comfortable keyboard.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-13.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-13.jpg'],
                'sku' => 'LEN-330-01',
                'badge_type' => 'top',
                'custom_badge_text' => 'Top',
                'display_order' => 4,
            ],
            [
                'name' => 'Sony Alpha a5100 Mirrorless Camera',
                'category' => 'Digital Cameras',
                'brand' => 'Sony',
                'price' => 499.99,
                'old_price' => null,
                'quantity' => 12,
                'short_description' => 'Compact mirrorless camera with 24MP sensor and fast autofocus.',
                'description' => '<p>The Sony Alpha a5100 packs pro-quality imaging into a compact body with a 24.2MP sensor and lightning-fast autofocus.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-14.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-14.jpg', 'assets/images/demos/demo-4/products/product-13.jpg'],
                'sku' => 'SONY-A5100-01',
                'badge_type' => 'top',
                'custom_badge_text' => 'Top',
                'display_order' => 5,
            ],
            [
                'name' => 'Google Home Mini Smart Speaker',
                'category' => 'Laptops',
                'brand' => 'Google',
                'price' => 49.00,
                'old_price' => null,
                'quantity' => 40,
                'short_description' => 'Compact smart speaker with the Google Assistant built in.',
                'description' => '<p>Get answers, play music, and control your smart home with the Google Home Mini, powered by the Google Assistant.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-15.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-15.jpg'],
                'sku' => 'GOOG-HM-01',
                'badge_type' => 'top',
                'custom_badge_text' => 'Top',
                'display_order' => 6,
            ],
            [
                'name' => 'WONDERBOOM Portable Bluetooth Speaker',
                'category' => 'Audio',
                'brand' => 'UE',
                'price' => 99.99,
                'old_price' => 129.99,
                'quantity' => 25,
                'short_description' => 'Waterproof portable Bluetooth speaker with 360° sound.',
                'description' => '<p>Take your music anywhere with the WONDERBOOM. This compact, waterproof speaker delivers surprisingly big 360° sound.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-16.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-16.jpg'],
                'sku' => 'UE-WB-01',
                'badge_type' => 'sale',
                'custom_badge_text' => 'Sale',
                'display_order' => 7,
            ],
            [
                'name' => 'Google Home Hub with Google Assistant',
                'category' => 'Smart Home',
                'brand' => 'Google',
                'price' => 149.00,
                'old_price' => null,
                'quantity' => 16,
                'short_description' => 'Voice-controlled smart display with the Google Assistant.',
                'description' => '<p>The Google Home Hub helps you manage your day, control smart devices, and enjoy entertainment on a vibrant display.</p>',
                'image' => 'assets/images/demos/demo-4/products/product-17.jpg',
                'gallery' => ['assets/images/demos/demo-4/products/product-17.jpg'],
                'sku' => 'GOOG-HH-01',
                'badge_type' => 'new',
                'custom_badge_text' => 'New',
                'display_order' => 8,
            ],
        ];

        foreach ($products as $data) {
            $categoryId = $this->category($data['category']);
            $brandId = $this->brand($data['brand']);

            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'name' => $data['name'],
                    'slug' => \Illuminate\Support\Str::slug($data['name']) . '-recommendation',
                    'category_id' => $categoryId,
                    'brand_id' => $brandId,
                    'price' => $data['price'],
                    'old_price' => $data['old_price'],
                    'quantity' => $data['quantity'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'shipping_information' => $shipping,
                    'return_policy' => $returns,
                    'image' => $data['image'],
                    'sku' => $data['sku'],
                    'is_active' => true,
                    'is_recommendation' => true,
                    'badge_type' => $data['badge_type'],
                    'custom_badge_text' => $data['custom_badge_text'],
                    'display_order' => $data['display_order'],
                ]
            );

            if (isset($data['gallery'])) {
                $order = 1;
                foreach ($data['gallery'] as $galleryImage) {
                    ProductImage::updateOrCreate(
                        ['product_id' => $product->id, 'image' => $galleryImage],
                        ['order' => $order++]
                    );
                }
            }
        }
    }
}
