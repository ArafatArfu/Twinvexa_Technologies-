<?php

namespace Database\Seeders;

use App\Models\NavbarSetting;
use Illuminate\Database\Seeder;

class NavbarSettingsSeeder extends Seeder
{
    public function run(): void
    {
        NavbarSetting::firstOrCreate(
            ['id' => 1],
            [
                'logo' => 'assets/images/demos/demo-4/logo.png',
                'logo_text' => 'Molla',
                'sticky_class' => 'header-4',
                'contact_number' => '+0123 456 789',
                'contact_icon' => 'icon-phone',
                'top_bar_text' => 'Clearance',
                'top_bar_highlight' => 'Up to 30% Off',
                'logo_width' => 65,
                'logo_height' => 16,
            ]
        );
    }
}