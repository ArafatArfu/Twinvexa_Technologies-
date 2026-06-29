<?php

namespace Database\Seeders;

use App\Models\HeaderSection;
use Illuminate\Database\Seeder;

class HeaderSectionSeeder extends Seeder
{
    public function run(): void
    {
        HeaderSection::insert([
            ['type' => 'top_bar', 'key' => 'top_bar', 'title' => 'Top Bar', 'order' => 1, 'is_visible' => true],
            ['type' => 'main_menu', 'key' => 'main_menu', 'title' => 'Main Menu', 'order' => 2, 'is_visible' => true],
            ['type' => 'mobile_menu', 'key' => 'mobile_menu', 'title' => 'Mobile Menu', 'order' => 3, 'is_visible' => true],
        ]);
    }
}