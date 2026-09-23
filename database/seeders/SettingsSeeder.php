<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Twinvexa Technology BD', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Your trusted technology partner in Bangladesh', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => 'assets/images/logo.png', 'type' => 'image', 'group' => 'general'],
            ['key' => 'top_bar_text', 'value' => 'Clearance', 'type' => 'text', 'group' => 'general'],
            ['key' => 'top_bar_highlight', 'value' => 'Up to 30% Off', 'type' => 'text', 'group' => 'general'],
            
            // SEO
            ['key' => 'seo_title', 'value' => 'Twinvexa Technology BD - Best Online Store', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'seo_description', 'value' => 'Shop the latest electronics, gadgets and accessories at Twinvexa Technology BD. Best prices, fast delivery.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'seo_keywords', 'value' => 'electronics, gadgets, technology, bangladesh, online store', 'type' => 'text', 'group' => 'seo'],
            
            // Contact
            ['key' => 'contact_email', 'value' => 'info@twinvexatechnologybd.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+8801234567890', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Dhaka, Bangladesh', 'type' => 'textarea', 'group' => 'contact'],
            
            // Footer
            ['key' => 'footer_copyright', 'value' => 'Copyright &copy; ' . date('Y') . ' Twinvexa Technology BD. All Rights Reserved.', 'type' => 'text', 'group' => 'footer'],
            ['key' => 'footer_description', 'value' => 'We provide the best technology products in Bangladesh.', 'type' => 'textarea', 'group' => 'footer'],
            ['key' => 'newsletter_text', 'value' => 'Subscribe to our newsletter to receive timely updates from your favorite products.', 'type' => 'textarea', 'group' => 'footer'],
            
            // Homepage sections
            ['key' => 'homepage_title', 'value' => 'Welcome to Twinvexa Technology BD', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'new_arrivals_title', 'value' => 'New Arrivals', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'trending_title', 'value' => 'Keyboard', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'deals_title', 'value' => 'Deals & Outlet', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'recommendations_title', 'value' => 'Recommendation For You', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'categories_title', 'value' => 'Explore Popular Categories', 'type' => 'text', 'group' => 'homepage'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
