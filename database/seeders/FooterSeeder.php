<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterSetting;
use App\Models\FooterLink;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        $settings = FooterSetting::first();
        if (!$settings) {
            $settings = FooterSetting::create([
                'newsletter_title' => 'Get The Latest Deals',
                'newsletter_subtitle' => 'and receive <span class="font-weight-normal">$20 coupon</span> for first shopping',
                'email_placeholder' => 'Enter your Email Address',
                'button_text' => 'Subscribe',
                'is_newsletter_active' => true,
                'footer_description' => 'Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam hendrerit mi elit, et posuere orci dignissim ut.',
                'phone_support_text' => 'Got Question? Call us 24/7',
                'phone_number' => '+0123 456 789',
                'support_icon' => 'icon-phone',
                'copyright_text' => 'Copyright &copy; 2024 Molla Store. All Rights Reserved.',
                'is_active' => true,
            ]);
        }

        $links = [
            ['column_type' => 'useful_links', 'title' => 'About Molla', 'url' => '/about', 'display_order' => 1, 'is_active' => true],
            ['column_type' => 'useful_links', 'title' => 'Our Services', 'url' => '/services', 'display_order' => 2, 'is_active' => true],
            ['column_type' => 'useful_links', 'title' => 'How to shop on Molla', 'url' => '/how-to-shop', 'display_order' => 3, 'is_active' => true],
            ['column_type' => 'useful_links', 'title' => 'FAQ', 'url' => '/faq', 'display_order' => 4, 'is_active' => true],
            ['column_type' => 'useful_links', 'title' => 'Contact us', 'url' => '/contact', 'display_order' => 5, 'is_active' => true],

            ['column_type' => 'customer_service', 'title' => 'Payment Methods', 'url' => '/payment-methods', 'display_order' => 1, 'is_active' => true],
            ['column_type' => 'customer_service', 'title' => 'Money-back guarantee!', 'url' => '/money-back', 'display_order' => 2, 'is_active' => true],
            ['column_type' => 'customer_service', 'title' => 'Returns', 'url' => '/returns', 'display_order' => 3, 'is_active' => true],
            ['column_type' => 'customer_service', 'title' => 'Shipping', 'url' => '/shipping', 'display_order' => 4, 'is_active' => true],
            ['column_type' => 'customer_service', 'title' => 'Terms and conditions', 'url' => '/terms', 'display_order' => 5, 'is_active' => true],
            ['column_type' => 'customer_service', 'title' => 'Privacy Policy', 'url' => '/privacy', 'display_order' => 6, 'is_active' => true],

            ['column_type' => 'my_account', 'title' => 'Sign In', 'url' => '/login', 'display_order' => 1, 'is_active' => true],
            ['column_type' => 'my_account', 'title' => 'View Cart', 'url' => '/cart', 'display_order' => 2, 'is_active' => true],
            ['column_type' => 'my_account', 'title' => 'My Wishlist', 'url' => '/wishlist', 'display_order' => 3, 'is_active' => true],
            ['column_type' => 'my_account', 'title' => 'Track My Order', 'url' => '/track-order', 'display_order' => 4, 'is_active' => true],
            ['column_type' => 'my_account', 'title' => 'Help', 'url' => '/help', 'display_order' => 5, 'is_active' => true],
        ];

        foreach ($links as $linkData) {
            FooterLink::updateOrCreate(
                ['column_type' => $linkData['column_type'], 'title' => $linkData['title']],
                $linkData
            );
        }
    }
}
