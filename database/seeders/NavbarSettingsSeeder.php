<?php

namespace Database\Seeders;

use App\Models\NavbarSetting;
use Illuminate\Database\Seeder;

class NavbarSettingsSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(
            ['key' => 'top_bar_text'],
            ['value' => 'Clearance', 'type' => 'text', 'group' => 'general']
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'top_bar_highlight'],
            ['value' => 'Up to 30% Off', 'type' => 'text', 'group' => 'general']
        );

        NavbarSetting::firstOrCreate(
            ['id' => 1],
            [
                'logo' => 'assets/images/demos/demo-4/logo.png',
                'logo_text' => 'TwinVexa Technology BD',
                'sticky_class' => 'header-4',
                'contact_number' => '+0123 456 789',
                'contact_icon' => 'icon-phone',
                'logo_width' => 65,
                'logo_height' => 16,
            ]
        );
    }
}