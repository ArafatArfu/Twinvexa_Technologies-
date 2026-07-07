<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IconBox;

class IconBoxSeeder extends Seeder
{
    public function run(): void
    {
        $iconBoxes = [
            [
                'title' => 'Free Shipping',
                'subtitle' => 'Orders $50 or more',
                'icon_class' => 'icon-rocket',
                'icon_image' => null,
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Free Returns',
                'subtitle' => 'Within 30 days',
                'icon_class' => 'icon-rotate-left',
                'icon_image' => null,
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Get 20% Off 1 Item',
                'subtitle' => 'when you sign up',
                'icon_class' => 'icon-info-circle',
                'icon_image' => null,
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'We Support',
                'subtitle' => '24/7 amazing services',
                'icon_class' => 'icon-life-ring',
                'icon_image' => null,
                'display_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($iconBoxes as $boxData) {
            IconBox::updateOrCreate(
                ['title' => $boxData['title']],
                $boxData
            );
        }
    }
}
