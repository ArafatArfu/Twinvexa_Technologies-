<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandDemoSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'short_description' => 'Premium consumer electronics and software.',
                'description' => 'Apple Inc. is an American multinational technology company that specializes in consumer electronics, software, and online services. Apple is the largest technology company by revenue and is known for its innovative products like the iPhone, iPad, Mac, and Apple Watch.',
                'website_url' => 'https://www.apple.com',
                'logo' => 'assets/images/brands/1.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'short_description' => 'Global leader in electronics and digital technology.',
                'description' => 'Samsung Electronics is a South Korean multinational electronics corporation. It is one of the world\'s largest manufacturers of consumer electronics, semiconductors, and telecommunications equipment.',
                'website_url' => 'https://www.samsung.com',
                'logo' => 'assets/images/brands/2.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'short_description' => 'Innovative entertainment and technology products.',
                'description' => 'Sony Corporation is a Japanese multinational conglomerate with a diversified business including electronics, gaming, entertainment, and financial services. Sony is known for PlayStation, Sony Bravia TVs, and high-quality cameras.',
                'website_url' => 'https://www.sony.com',
                'logo' => 'assets/images/brands/3.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Bose',
                'slug' => 'bose',
                'short_description' => 'Premium audio equipment and sound systems.',
                'description' => 'Bose Corporation is an American manufacturing company that sells audio equipment. Bose is known for high-quality speakers, noise-cancelling headphones, and professional audio systems.',
                'website_url' => 'https://www.bose.com',
                'logo' => 'assets/images/brands/4.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => false,
                'display_order' => 4,
            ],
            [
                'name' => 'Google',
                'slug' => 'google',
                'short_description' => 'Search, cloud, and AI-powered devices.',
                'description' => 'Google LLC is an American multinational technology company focusing on search engine technology, online advertising, cloud computing, and artificial intelligence. Google Pixel phones and Nest devices are popular consumer products.',
                'website_url' => 'https://www.google.com',
                'logo' => 'assets/images/brands/5.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => true,
                'display_order' => 5,
            ],
            [
                'name' => 'LG',
                'slug' => 'lg',
                'short_description' => 'Life\'s Good - electronics and appliances.',
                'description' => 'LG Electronics is a South Korean multinational electronics company. LG produces a wide range of consumer electronics, home appliances, and mobile devices, known for innovation in display technologies and smart home solutions.',
                'website_url' => 'https://www.lg.com',
                'logo' => 'assets/images/brands/6.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => true,
                'display_order' => 6,
            ],
            [
                'name' => 'Canon',
                'slug' => 'canon',
                'short_description' => 'Professional imaging and optical products.',
                'description' => 'Canon Inc. is a Japanese multinational corporation specializing in optical, imaging, and industrial products. Canon is renowned for its cameras, lenses, printers, and medical equipment.',
                'website_url' => 'https://www.canon.com',
                'logo' => 'assets/images/brands/7.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => false,
                'display_order' => 7,
            ],
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'short_description' => 'Just Do It - athletic footwear and apparel.',
                'description' => 'Nike, Inc. is an American multinational corporation that designs, develops, and sells athletic footwear, apparel, and accessories. Nike is one of the world\'s largest suppliers of athletic shoes and apparel.',
                'website_url' => 'https://www.nike.com',
                'logo' => 'assets/images/brands/8.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => true,
                'display_order' => 8,
            ],
            [
                'name' => 'Adidas',
                'slug' => 'adidas',
                'short_description' => 'Impossible Is Nothing - sportswear and lifestyle.',
                'description' => 'Adidas AG is a German multinational corporation that designs and manufactures sports shoes, clothing, and accessories. Adidas is the largest sportswear manufacturer in Europe and the second largest in the world.',
                'website_url' => 'https://www.adidas.com',
                'logo' => 'assets/images/brands/9.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => true,
                'display_order' => 9,
            ],
            [
                'name' => 'Puma',
                'slug' => 'puma',
                'short_description' => 'Forever Faster - athletic and casual footwear.',
                'description' => 'PUMA is a German multinational corporation that designs and manufactures athletic and casual footwear, apparel, and accessories. PUMA is one of the world\'s leading sports brands.',
                'website_url' => 'https://www.puma.com',
                'logo' => 'assets/images/brands/1.png',
                'banner_image' => null,
                'is_active' => true,
                'is_featured' => false,
                'display_order' => 10,
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::updateOrCreate(
                ['slug' => $brandData['slug']],
                [
                    'name' => $brandData['name'],
                    'short_description' => $brandData['short_description'],
                    'description' => $brandData['description'],
                    'website_url' => $brandData['website_url'],
                    'logo' => $brandData['logo'],
                    'banner_image' => $brandData['banner_image'],
                    'is_active' => $brandData['is_active'],
                    'is_featured' => $brandData['is_featured'],
                    'display_order' => $brandData['display_order'],
                ]
            );
        }
    }
}
