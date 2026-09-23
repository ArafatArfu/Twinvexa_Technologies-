<?php

namespace Database\Seeders;

use App\Models\NavbarItem;
use App\Models\NavbarSetting;
use Illuminate\Database\Seeder;

class NavbarSeeder extends Seeder
{
    public function run(): void
    {
        NavbarSetting::create([
            'logo' => 'assets/images/demos/demo-4/logo.png',
            'sticky_class' => 'header-4',
        ]);

        $home = NavbarItem::create([
            'title' => 'Home',
            'url' => '/',
            'order' => 1,
            'is_visible' => true,
        ]);

        NavbarItem::create([
            'title' => 'Shop',
            'url' => '#',
            'order' => 2,
            'is_visible' => true,
            'is_dropdown' => true,
        ]);

        NavbarItem::create([
            'title' => 'Product',
            'url' => '#',
            'order' => 3,
            'is_visible' => true,
            'is_dropdown' => true,
        ]);

        NavbarItem::create([
            'title' => 'Pages',
            'url' => '#',
            'order' => 4,
            'is_visible' => true,
            'is_dropdown' => true,
        ]);

        NavbarItem::create([
            'title' => 'Blog',
            'url' => '#',
            'order' => 5,
            'is_visible' => true,
            'is_dropdown' => true,
        ]);

        NavbarItem::create([
            'title' => 'Elements',
            'url' => '#',
            'order' => 6,
            'is_visible' => true,
            'is_dropdown' => true,
        ]);
    }
}