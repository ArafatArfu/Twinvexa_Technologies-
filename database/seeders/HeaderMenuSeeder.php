<?php

namespace Database\Seeders;

use App\Models\HeaderMenu;
use Illuminate\Database\Seeder;

class HeaderMenuSeeder extends Seeder
{
    public function run(): void
    {
        $mainSection = \App\Models\HeaderSection::where('key', 'main_menu')->first();

        if (!$mainSection) {
            return;
        }

        // Home with megamenu demo
        $home = HeaderMenu::create([
            'title' => 'Home',
            'url' => '/',
            'section_id' => $mainSection->id,
            'order' => 1,
            'is_visible' => true,
            'is_megamenu' => true,
            'megamenu_class' => 'demo',
        ]);

        // Shop with megamenu
        $shop = HeaderMenu::create([
            'title' => 'Shop',
            'url' => '#',
            'section_id' => $mainSection->id,
            'order' => 2,
            'is_visible' => true,
            'is_megamenu' => true,
            'megamenu_class' => 'shop-content',
        ]);

        // Product with megamenu
        $product = HeaderMenu::create([
            'title' => 'Product',
            'url' => '#',
            'section_id' => $mainSection->id,
            'order' => 3,
            'is_visible' => true,
            'is_megamenu' => true,
            'megamenu_class' => 'product',
        ]);

        // Pages (regular dropdown)
        $pages = HeaderMenu::create([
            'title' => 'Pages',
            'url' => '#',
            'section_id' => $mainSection->id,
            'order' => 4,
            'is_visible' => true,
            'is_megamenu' => false,
        ]);

        // Pages submenu
        HeaderMenu::create([
            'title' => 'About 01',
            'url' => '#',
            'section_id' => $mainSection->id,
            'parent_id' => $pages->id,
            'order' => 1,
            'is_visible' => true,
        ]);
        HeaderMenu::create([
            'title' => 'About 02',
            'url' => '#',
            'section_id' => $mainSection->id,
            'parent_id' => $pages->id,
            'order' => 2,
            'is_visible' => true,
        ]);
        HeaderMenu::create([
            'title' => 'Contact 01',
            'url' => '#',
            'section_id' => $mainSection->id,
            'parent_id' => $pages->id,
            'order' => 3,
            'is_visible' => true,
        ]);
        HeaderMenu::create([
            'title' => 'Login',
            'url' => '#',
            'section_id' => $mainSection->id,
            'parent_id' => $pages->id,
            'order' => 4,
            'is_visible' => true,
        ]);
        HeaderMenu::create([
            'title' => 'FAQs',
            'url' => '#',
            'section_id' => $mainSection->id,
            'parent_id' => $pages->id,
            'order' => 5,
            'is_visible' => true,
        ]);

        // Blog (regular dropdown)
        $blog = HeaderMenu::create([
            'title' => 'Blog',
            'url' => '#',
            'section_id' => $mainSection->id,
            'order' => 5,
            'is_visible' => true,
            'is_megamenu' => false,
        ]);

        // Elements (regular dropdown)
        $elements = HeaderMenu::create([
            'title' => 'Elements',
            'url' => '#',
            'section_id' => $mainSection->id,
            'order' => 6,
            'is_visible' => true,
            'is_megamenu' => false,
        ]);
    }
}