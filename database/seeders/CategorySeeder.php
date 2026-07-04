<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Computer & Laptop',
                'slug' => 'computer-laptop',
                'short_description' => 'Explore our wide range of laptops, desktops, and accessories.',
                'description' => 'From powerful gaming laptops to efficient office desktops, find the perfect computing solution for your needs.',
                'order' => 1,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Digital Cameras',
                'slug' => 'digital-cameras',
                'short_description' => 'Capture life\'s moments with professional digital cameras.',
                'description' => 'Discover DSLR, mirrorless, and compact digital cameras from top brands.',
                'order' => 2,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Smart Phones',
                'slug' => 'smart-phones',
                'short_description' => 'Latest smartphones with advanced features and great deals.',
                'description' => 'Browse the newest smartphones with cutting-edge technology, stunning cameras, and all-day battery life.',
                'order' => 3,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Televisions',
                'slug' => 'televisions',
                'short_description' => 'Experience stunning visuals with our TV collection.',
                'description' => 'From 4K Ultra HD to Smart TVs, find the perfect television for your home entertainment.',
                'order' => 4,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
                'short_description' => 'Premium audio equipment for the best listening experience.',
                'description' => 'Headphones, speakers, soundbars, and audio accessories for music lovers and professionals.',
                'order' => 5,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Smart Watches',
                'slug' => 'smart-watches',
                'short_description' => 'Stay connected with smart wearables and fitness trackers.',
                'description' => 'Track your fitness, stay connected, and access information at a glance with our smart watch collection.',
                'order' => 6,
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
