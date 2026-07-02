<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\ProductTag;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::create([
            'name' => 'Tablets',
            'slug' => 'tablets',
            'is_active' => true,
        ]);

        $brand = Brand::create([
            'name' => 'Apple',
            'slug' => 'apple',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Apple iPad Pro 12.9 Inch, 64GB',
            'slug' => 'apple-ipad-pro',
            'description' => '<p>The Apple iPad Pro 12.9-inch features a stunning Liquid Retina XDR display with ProMotion technology, making it the ultimate device for creativity and productivity. Powered by the M2 chip, it delivers exceptional performance for demanding tasks.</p><p>Featuring a 12-megapixel Wide camera and 10-megapixel Ultra Wide camera with LiDAR Scanner, the iPad Pro captures stunning photos and videos. The all-screen design with thin bezels provides an immersive experience.</p>',
            'short_description' => 'Apple iPad Pro 12.9-inch with M2 chip, Liquid Retina XDR display, 64GB storage, and all-day battery life.',
            'sku' => 'IPAD-PRO-12-64',
            'price' => '999.99',
            'old_price' => null,
            'image' => 'assets/images/demos/demo-4/products/single/ipad-pro-1.jpg',
            'quantity' => 15,
            'is_active' => true,
            'is_featured' => true,
            'is_new' => true,
            'is_sale' => false,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'assets/images/demos/demo-4/products/single/ipad-pro-1.jpg',
            'order' => 1,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'assets/images/demos/demo-4/products/single/ipad-pro-2.jpg',
            'order' => 2,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'assets/images/demos/demo-4/products/single/ipad-pro-3.jpg',
            'order' => 3,
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => '128GB / Silver',
            'sku' => 'IPAD-PRO-12-128-SL',
            'price' => '1099.99',
            'old_price' => null,
            'quantity' => 10,
            'attribute_name' => 'Configuration',
            'attribute_value' => '128GB / Silver',
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => '256GB / Space Gray',
            'sku' => 'IPAD-PRO-12-256-SG',
            'price' => '1199.99',
            'old_price' => '1299.99',
            'quantity' => 8,
            'attribute_name' => 'Configuration',
            'attribute_value' => '256GB / Space Gray',
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Brand',
            'value' => 'Apple',
            'order' => 1,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Model',
            'value' => 'iPad Pro 12.9-inch (6th generation)',
            'order' => 2,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Display',
            'value' => '12.9-inch Liquid Retina XDR display',
            'order' => 3,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Processor',
            'value' => 'Apple M2 chip',
            'order' => 4,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'RAM',
            'value' => '8GB',
            'order' => 5,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Storage',
            'value' => '64GB',
            'order' => 6,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Camera',
            'value' => '12MP Wide + 10MP Ultra Wide',
            'order' => 7,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Battery',
            'value' => 'Up to 10 hours',
            'order' => 8,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Operating System',
            'value' => 'iPadOS 16',
            'order' => 9,
        ]);

        ProductSpecification::create([
            'product_id' => $product->id,
            'key' => 'Weight',
            'value' => '682g (Wi-Fi)',
            'order' => 10,
        ]);

        Review::create([
            'product_id' => $product->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'rating' => 5,
            'comment' => 'Absolutely amazing tablet! The display is stunning and the M2 chip handles everything I throw at it.',
            'is_verified' => true,
        ]);

        Review::create([
            'product_id' => $product->id,
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'rating' => 4,
            'comment' => 'Great device for creative work. Battery life could be better but overall very satisfied.',
            'is_verified' => true,
        ]);

        ProductTag::create([
            'product_id' => $product->id,
            'tag' => 'tablet',
        ]);

        ProductTag::create([
            'product_id' => $product->id,
            'tag' => 'apple',
        ]);

        ProductTag::create([
            'product_id' => $product->id,
            'tag' => 'ipad-pro',
        ]);

        $secondProduct = Product::create([
            'name' => 'Apple MacBook Pro 13-inch M2',
            'slug' => 'apple-macbook-pro-13-m2',
            'description' => '<p>The MacBook Pro 13-inch with M2 chip delivers exceptional performance in a remarkably compact design. Featuring a brilliant Retina display and all-day battery life.</p>',
            'short_description' => 'MacBook Pro 13-inch with M2 chip, 8-core CPU, 10-core GPU, 8GB RAM, 512GB SSD.',
            'sku' => 'MBP-13-M2-512',
            'price' => '1299.99',
            'old_price' => '1499.99',
            'image' => 'assets/images/demos/demo-4/products/single/macbook-pro-1.jpg',
            'quantity' => 8,
            'is_active' => true,
            'is_featured' => true,
            'is_new' => false,
            'is_sale' => true,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
        ]);

        ProductImage::create([
            'product_id' => $secondProduct->id,
            'image' => 'assets/images/demos/demo-4/products/single/macbook-pro-1.jpg',
            'order' => 1,
        ]);

        ProductImage::create([
            'product_id' => $secondProduct->id,
            'image' => 'assets/images/demos/demo-4/products/single/macbook-pro-2.jpg',
            'order' => 2,
        ]);

        ProductSpecification::create([
            'product_id' => $secondProduct->id,
            'key' => 'Brand',
            'value' => 'Apple',
            'order' => 1,
        ]);

        ProductSpecification::create([
            'product_id' => $secondProduct->id,
            'key' => 'Processor',
            'value' => 'Apple M2 chip',
            'order' => 2,
        ]);

        ProductSpecification::create([
            'product_id' => $secondProduct->id,
            'key' => 'Display',
            'value' => '13.3-inch Retina display',
            'order' => 3,
        ]);

        ProductSpecification::create([
            'product_id' => $secondProduct->id,
            'key' => 'Storage',
            'value' => '512GB SSD',
            'order' => 4,
        ]);

        Review::create([
            'product_id' => $secondProduct->id,
            'name' => 'Alice Cooper',
            'email' => 'alice@example.com',
            'rating' => 5,
            'comment' => 'The best laptop I have ever owned. Fast, reliable, and beautiful.',
            'is_verified' => true,
        ]);
    }
}
