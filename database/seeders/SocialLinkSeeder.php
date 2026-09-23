<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            ['platform' => 'Facebook', 'url' => 'https://facebook.com', 'icon_class' => 'icon-facebook-f', 'display_order' => 1],
            ['platform' => 'Twitter', 'url' => 'https://twitter.com', 'icon_class' => 'icon-twitter', 'display_order' => 2],
            ['platform' => 'Instagram', 'url' => 'https://instagram.com', 'icon_class' => 'icon-instagram', 'display_order' => 3],
            ['platform' => 'Pinterest', 'url' => 'https://pinterest.com', 'icon_class' => 'icon-pinterest', 'display_order' => 4],
            ['platform' => 'Youtube', 'url' => 'https://youtube.com', 'icon_class' => 'icon-youtube', 'display_order' => 5],
        ];

        foreach ($links as $link) {
            SocialLink::updateOrCreate(['platform' => $link['platform']], $link);
        }
    }
}
